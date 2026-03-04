<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LiderController extends Controller
{
    /**
     * Mostrar dashboard del líder con pedidos
     */
    public function index()
    {
        $user = Auth::user();
        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->with(['usuario', 'ficha.programa', 'elementos'])->get();

        return view('dashboard.lider', [
            'pedidos' => $pedidos,
            'user' => $user
        ]);
    }

    /**
     * 👈 NUEVO: Obtener resumen consolidado de pedidos del área del líder (AJAX)
     */
    public function resumenConsolidado()
    {
        try {
            $areaId = Auth::user()->areas_id;

            // Obtener todos los pedidos del área
            $pedidos = Pedido::with(['elementos' => function($q) use ($areaId) {
                $q->where('areas_id', $areaId);
            }, 'usuario'])
            ->whereHas('usuario', function ($query) use ($areaId) {
                $query->where('areas_id', $areaId);
            })
            ->get();

            if ($pedidos->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay pedidos para tu área'
                ], 404);
            }

            // Consolidar: agrupar por nombre de producto y talla
            $consolidado = [];

            foreach ($pedidos as $pedido) {
                foreach ($pedido->elementos as $elemento) {
                    $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');

                    if (!isset($consolidado[$clave])) {
                        $consolidado[$clave] = [
                            'nombre' => $elemento->nombre,
                            'talla' => $elemento->pivot->talla ?? 'Sin talla especificada',
                            'cantidad_total' => 0,
                            'area' => $elemento->area->nombre ?? '-',
                            'proteccion' => $elemento->filtro->parte_del_cuerpo ?? '-',
                        ];
                    }

                    $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                }
            }

            // Ordenar por nombre
            uasort($consolidado, function($a, $b) {
                return strcmp($a['nombre'], $b['nombre']);
            });

            $totalUnidades = array_sum(array_column($consolidado, 'cantidad_total'));

            return response()->json([
                'success' => true,
                'consolidado' => array_values($consolidado),
                'total_pedidos' => $pedidos->count(),
                'total_unidades' => $totalUnidades
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en resumenConsolidado del líder: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cargar el resumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 👈 NUEVO: Exportar a Excel formato GFPI-F-186
     * Genera un archivo Excel con el resumen consolidado de pedidos
     */
    public function exportarGFPIF186()
    {
        try {
            $user = Auth::user();
            $areaId = $user->areas_id;

            // Obtener todos los pedidos del área
            $pedidos = Pedido::with(['elementos' => function($q) use ($areaId) {
                $q->where('areas_id', $areaId);
            }, 'usuario', 'ficha.programa'])
            ->whereHas('usuario', function ($query) use ($areaId) {
                $query->where('areas_id', $areaId);
            })
            ->get();

            if ($pedidos->isEmpty()) {
                return back()->with('error', 'No hay pedidos para exportar');
            }

            // Consolidar datos
            $consolidado = [];
            foreach ($pedidos as $pedido) {
                foreach ($pedido->elementos as $elemento) {
                    $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');

                    if (!isset($consolidado[$clave])) {
                        $consolidado[$clave] = [
                            'nombre' => $elemento->nombre,
                            'talla' => $elemento->pivot->talla ?? 'Sin talla',
                            'cantidad_total' => 0,
                            'proteccion' => $elemento->filtro->parte_del_cuerpo ?? '-',
                            'descripcion' => $elemento->descripcion ?? '-',
                        ];
                    }

                    $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;
                }
            }

            // Crear spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('GFPI-F-186');

            // Estilos (simplificados)

            // Encabezado del documento
            $sheet->setCellValue('A1', 'FORMATO GFPI-F-186');
            $sheet->mergeCells('A1:E1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $sheet->setCellValue('A2', 'SOLICITUD DE EQUIPOS DE PROTECCIÓN PERSONAL (EPP)');
            $sheet->mergeCells('A2:E2');
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(12);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            // Información del área
            $sheet->setCellValue('A4', 'Área:');
            $sheet->setCellValue('B4', $user->area->nombre ?? 'No asignada');
            $sheet->setCellValue('D4', 'Fecha:');
            $sheet->setCellValue('E4', now()->format('d/m/Y'));

            $sheet->setCellValue('A5', 'Líder:');
            $sheet->setCellValue('B5', $user->nombre_completo);
            $sheet->setCellValue('D5', 'Total Pedidos:');
            $sheet->setCellValue('E5', $pedidos->count());

            // Encabezados de tabla
            $row = 7;
            $headers = ['Nº', 'Producto', 'Talla', 'Cantidad', 'Protección'];

            foreach ($headers as $col => $header) {
                $cell = $sheet->getCellByColumnAndRow($col + 1, $row);
                $cell->setValue($header);
            }

            $headerRange = 'A' . $row . ':E' . $row;
            $sheet->getStyle($headerRange)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '39A900']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            // Datos consolidados
            $row = 8;
            $numero = 1;
            $totalCantidad = 0;

            foreach ($consolidado as $item) {
                $sheet->setCellValue('A' . $row, $numero);
                $sheet->setCellValue('B' . $row, $item['nombre']);
                $sheet->setCellValue('C' . $row, $item['talla']);
                $sheet->setCellValue('D' . $row, $item['cantidad_total']);
                $sheet->setCellValue('E' . $row, $item['proteccion']);

                // Aplicar bordes a toda la fila
                $dataRange = 'A' . $row . ':E' . $row;
                $sheet->getStyle($dataRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ]
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ]
                ]);

                $totalCantidad += $item['cantidad_total'];
                $numero++;
                $row++;
            }

            // Fila de totales
            $row++;
            $sheet->setCellValue('B' . $row, 'TOTAL');
            $sheet->setCellValue('D' . $row, $totalCantidad);

            $totalRange = 'A' . $row . ':E' . $row;
            $sheet->getStyle($totalRange)->applyFromArray([
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '39A900']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ]
                ]
            ]);

            // Ajustar ancho de columnas
            $sheet->getColumnDimension('A')->setWidth(8);
            $sheet->getColumnDimension('B')->setWidth(30);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(20);

            // Generar archivo
            $writer = new Xlsx($spreadsheet);
            $filename = 'GFPI-F-186_' . $user->area->nombre . '_' . now()->format('d-m-Y_H-i-s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            \Log::error('Error al exportar GFPI-F-186', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'No fue posible generar el archivo. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Enviar un pedido al administrador
     */
    public function enviarPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $user = Auth::user();

        if ($pedido->usuario->areas_id !== $user->areas_id) {
            return redirect()->back()->with('error', 'No tienes permiso para enviar este pedido');
        }

        $pedido->update(['estado' => 'enviado']);

        // --- NOTIFICACIÓN PARA ADMINISTRADORES ---
        $admins = User::where('roles_id', 1)->get();
        foreach ($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'tipo' => 'nuevo_pedido',
                'titulo' => 'Nuevo Pedido Recibido',
                'mensaje' => "El líder {$user->nombre_completo} ha enviado el pedido #{$pedido->id} para revisión.",
                'pedido_id' => $pedido->id,
                'usuario_accion_id' => $user->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Líder' => $user->nombre_completo,
                    'Área' => $user->area->nombre ?? 'No asignada',
                    'Pedido_ID' => "#" . $pedido->id,
                    'Fecha_Envío' => now()->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Pedido enviado al administrador correctamente');
    }

    /**
     * Enviar todos los pedidos pendientes
     */
    public function enviarTodos()
    {
        $user = Auth::user();

        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->where('estado', 'pendiente')->get();

        if ($pedidos->isEmpty()) {
            return redirect()->back()->with('info', 'No hay pedidos pendientes para enviar');
        }

        foreach ($pedidos as $pedido) {
            $pedido->update(['estado' => 'enviado']);
        }

        // --- NOTIFICACIÓN PARA ADMINISTRADORES (Consolidado) ---
        $admins = User::where('roles_id', 1)->get();
        foreach ($admins as $admin) {
            Notificacion::create([
                'user_id' => $admin->id,
                'tipo' => 'consolidado_pedidos',
                'titulo' => 'Consolidado de Pedidos Enviado',
                'mensaje' => "Se han enviado " . $pedidos->count() . " pedidos del área de {$user->nombre_completo} para revisión.",
                'usuario_accion_id' => $user->id,
                'leida' => false,
                'datos_adicionales' => [
                    'Líder' => $user->nombre_completo,
                    'Área' => $user->area->nombre ?? 'No asignada',
                    'Total_Pedidos' => $pedidos->count(),
                    'Fecha_Envío' => now()->format('d/m/Y H:i')
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Se enviaron ' . $pedidos->count() . ' pedidos al administrador');
    }

    /**
     * Aprobar un pedido
     */
    public function aprobar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => 'aprobado']);
        return redirect()->back()->with('success', 'Pedido aprobado correctamente');
    }

    /**
     * Rechazar un pedido
     */
    public function rechazar($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->update(['estado' => 'rechazado']);
        return redirect()->back()->with('success', 'Pedido rechazado correctamente');
    }
}
