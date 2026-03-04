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
     * 👈 NUEVO: Exportar a Excel formato GFPI-F-186 (Formato oficial SENA)
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
            $sheet->setTitle('Materiales');

            // Configurar ancho de columnas
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(30);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(12);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(12);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(12);

            // Encabezado - Fila 1
            $sheet->setCellValue('L1', 'Versión: 01');
            $sheet->getStyle('L1')->getFont()->setBold(true)->setSize(10);

            // Fila 2
            $sheet->setCellValue('L2', 'Código: GFPI-F-186');
            $sheet->getStyle('L2')->getFont()->setBold(true)->setSize(10);

            // Fila 3
            $sheet->setCellValue('B3', 'PROCEDIMIENTO DISEÑO CURRICULAR');
            $sheet->getStyle('B3')->getFont()->setBold(true)->setSize(11);

            // Fila 4
            $sheet->setCellValue('B4', 'FORMATO ANEXO LISTA DE MATERIALES DE FORMACIÓN REFERENTE');
            $sheet->getStyle('B4')->getFont()->setBold(true)->setSize(11);

            // Fila 6
            $sheet->setCellValue('B6', 'RED DE CONOCIMIENTO - INSTITUCIONAL');
            $sheet->setCellValue('C6', 'SENA');
            $sheet->setCellValue('G6', 'CÓDIGO DE PROGRAMA DE FORMACIÓN');

            // Fila 7
            $sheet->setCellValue('B7', 'NIVEL DE FORMACIÓN');
            $sheet->setCellValue('C7', 'TÉCNICO');
            $sheet->setCellValue('G7', 'DENOMINACIÓN PROGRAMA DE FORMACIÓN');
            $sheet->setCellValue('I7', $pedidos->first()->ficha->programa->nombre ?? 'No asignado');

            // Fila 8
            $sheet->setCellValue('B8', 'VERSIÓN');
            $sheet->setCellValue('C8', '1');
            $sheet->setCellValue('G8', 'FICHA ASIGNADA');
            $sheet->setCellValue('I8', $pedidos->first()->ficha->numero ?? 'N/A');

            // Fila 10
            $sheet->setCellValue('B10', 'INSTRUCTOR(ES) SOLICITANTE(S)');
            $sheet->setCellValue('C10', $pedidos->first()->usuario->nombre_completo ?? 'No asignado');
            $sheet->setCellValue('G10', 'LÍDER DEL ÁREA');
            $sheet->setCellValue('I10', $user->nombre_completo);

            // Fila 11
            $sheet->setCellValue('B11', 'FECHA DE GENERACIÓN');
            $sheet->setCellValue('C11', now()->format('d/m/Y H:i'));

            // Encabezados de tabla - Fila 13
            $headers = ['ÍTEM', 'CÓDIGO UNSPSC', 'PRODUCTO', 'DESCRIPCIÓN TÉCNICA REQUERIDA DEL BIEN', 'UNIDAD DE MEDIDA', 'CANTIDAD REQUERIDA PARA FORMAR 30 APRENDICES DURANTE LA FORMACIÓN', 'OBSERVACIONES', 'CONSUMO', 'DEVOLUTIVO', 'SOFTWARE', 'EPP'];

            $col = 1;
            foreach ($headers as $header) {
                $cell = $sheet->getCellByColumnAndRow($col, 13);
                $cell->setValue($header);
                $cell->getStyle()->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
                $cell->getStyle()->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF39A900');
                $cell->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                $cell->getStyle()->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ]
                    ]
                ]);
                $col++;
            }

            // Datos - Filas 14 en adelante
            $row = 14;
            $numero = 1;

            foreach ($consolidado as $item) {
                $sheet->setCellValue('A' . $row, $numero);
                $sheet->setCellValue('B' . $row, ''); // CÓDIGO UNSPSC (vacío)
                $sheet->setCellValue('C' . $row, $item['nombre']);
                $sheet->setCellValue('D' . $row, $item['descripcion']);
                $sheet->setCellValue('E' . $row, 'Unidad');
                $sheet->setCellValue('F' . $row, $item['cantidad_total']);
                $sheet->setCellValue('G' . $row, 'Talla: ' . $item['talla']);
                $sheet->setCellValue('H' . $row, ''); // CONSUMO
                $sheet->setCellValue('I' . $row, ''); // DEVOLUTIVO
                $sheet->setCellValue('J' . $row, ''); // SOFTWARE
                $sheet->setCellValue('K' . $row, 'X'); // EPP

                // Aplicar estilos a la fila
                for ($col = 1; $col <= 11; $col++) {
                    $cell = $sheet->getCellByColumnAndRow($col, $row);
                    $cell->getStyle()->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => Border::BORDER_THIN,
                            ]
                        ],
                        'alignment' => [
                            'horizontal' => Alignment::HORIZONTAL_LEFT,
                            'vertical' => Alignment::VERTICAL_CENTER,
                            'wrapText' => true
                        ]
                    ]);
                }

                // Centrar números
                $sheet->getCellByColumnAndRow(1, $row)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getCellByColumnAndRow(6, $row)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getCellByColumnAndRow(11, $row)->getStyle()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $numero++;
                $row++;
            }

            // Generar archivo
            $writer = new Xlsx($spreadsheet);
            $areaName = $user->area->nombre ?? 'Area';
            $filename = 'GFPI-F-186_' . str_replace(' ', '_', $areaName) . '_' . now()->format('d-m-Y') . '.xlsx';

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
