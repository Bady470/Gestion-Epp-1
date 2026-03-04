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

            // Configurar ancho de columnas (basado en el análisis del Excel original)
            $sheet->getColumnDimension('A')->setWidth(1.71);
            $sheet->getColumnDimension('B')->setWidth(2.86);
            $sheet->getColumnDimension('C')->setWidth(8.14);
            $sheet->getColumnDimension('D')->setWidth(26.0);
            $sheet->getColumnDimension('E')->setWidth(38.29);
            $sheet->getColumnDimension('F')->setWidth(61.86);
            $sheet->getColumnDimension('G')->setWidth(46.86);
            $sheet->getColumnDimension('H')->setWidth(35.0);
            $sheet->getColumnDimension('I')->setWidth(42.14);
            $sheet->getColumnDimension('J')->setWidth(1.14);
            $sheet->getColumnDimension('K')->setWidth(23.14);
            $sheet->getColumnDimension('L')->setWidth(13.0);
            $sheet->getColumnDimension('M')->setWidth(13.0);
            $sheet->getColumnDimension('N')->setWidth(13.0);
            $sheet->getColumnDimension('O')->setWidth(4.29);

            // Estilos generales para encabezados superiores
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'name' => 'Arial'
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ]
            ];

            // Fila 2 - Versión
            $sheet->mergeCells('M2:O2');
            $sheet->setCellValue('M2', 'Versión: 01');
            $sheet->getStyle('M2:O2')->applyFromArray($headerStyle);

            // Fila 3 - Código
            $sheet->mergeCells('M3:O3');
            $sheet->setCellValue('M3', 'Código: GFPI-F-186');
            $sheet->getStyle('M3:O3')->applyFromArray($headerStyle);

            // Fila 4 - Procedimiento
            $sheet->mergeCells('B4:O4');
            $sheet->setCellValue('B4', 'PROCEDIMIENTO DISEÑO CURRICULAR ');
            $sheet->getStyle('B4:O4')->applyFromArray($headerStyle);

            // Fila 5 - Formato
            $sheet->mergeCells('B5:O5');
            $sheet->setCellValue('B5', 'FORMATO ANEXO LISTA DE MATERIALES DE FORMACIÓN REFERENTE');
            $sheet->getStyle('B5:O5')->applyFromArray($headerStyle);

            // Estilo para campos de información general (Row 6, 7, 8)
            $infoStyle = [
                'font' => ['bold' => true, 'size' => 11, 'name' => 'Arial'],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE9ECEF'] // Color gris claro de fondo
                ],
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ];

            // Fila 6
            $sheet->mergeCells('C6:D6');
            $sheet->setCellValue('C6', 'RED DE CONOCIMIENTO - INSTITUCIONAL');
            $sheet->mergeCells('E6:F6');
            $sheet->setCellValue('E6', 'SENA');
            $sheet->mergeCells('H6:J6');
            $sheet->setCellValue('H6', 'CÓDIGO DE PROGRAMA DE FORMACIÓN ');
            $sheet->mergeCells('K6:N6');
            $sheet->setCellValue('K6', 'N/A');

            // Fila 7
            $sheet->mergeCells('C7:D7');
            $sheet->setCellValue('C7', 'NIVEL DE FORMACIÓN ');
            $sheet->mergeCells('E7:F7');
            $sheet->setCellValue('E7', 'TÉCNICO');
            $sheet->mergeCells('H7:J7');
            $sheet->setCellValue('H7', 'DENOMINACIÓN PROGRAMA DE FORMACIÓN ');
            $sheet->mergeCells('K7:N7');
            $sheet->setCellValue('K7', $pedidos->first()->ficha->programa->nombre ?? 'No asignado');

            // Fila 8
            $sheet->mergeCells('C8:D8');
            $sheet->setCellValue('C8', 'VERSIÓN ');
            $sheet->mergeCells('E8:F8');
            $sheet->setCellValue('E8', '1');
            $sheet->mergeCells('H8:J8');
            $sheet->setCellValue('H8', 'NOMBRE GESTOR DE RED');
            $sheet->mergeCells('K8:N8');
            $sheet->setCellValue('K8', $user->nombre_completo);

            $sheet->getStyle('C6:N8')->applyFromArray($infoStyle);

            // Encabezados de tabla - Fila 11
            $tableHeaders = [
                'C' => 'ÍTEM',
                'D' => 'CÓDIGO UNSPSC',
                'E' => 'PRODUCTO ',
                'F' => 'DESCRIPCION TÉCNICA REQUERIDA DEL BIEN ',
                'G' => 'UNIDAD DE MEDIDA ',
                'H' => 'CANTIDAD REQUERIDA PARA FORMAR 30 APRENDICES DURANTE LA FORMACIÓN',
                'I' => 'OBSERVACIONES',
                'K' => 'CONSUMO',
                'L' => 'DEVOLUTIVO',
                'M' => 'SOFTWARE',
                'N' => 'EPP'
            ];

            foreach ($tableHeaders as $col => $text) {
                $sheet->setCellValue($col . '11', $text);
                $style = $sheet->getStyle($col . '11');
                $style->getFont()->setBold(true)->setSize(10)->setName('Arial')->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFFFF'));
                $style->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF39A900');
                $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
                $style->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            }

            // Datos - Fila 13 en adelante
            $row = 13;
            $numero = 1;

            foreach ($consolidado as $item) {
                $sheet->setCellValue('C' . $row, $numero);
                $sheet->setCellValue('D' . $row, ''); // CÓDIGO UNSPSC
                $sheet->setCellValue('E' . $row, $item['nombre']);
                $sheet->setCellValue('F' . $row, $item['descripcion']);
                $sheet->setCellValue('G' . $row, 'Unidad');
                $sheet->setCellValue('H' . $row, $item['cantidad_total']);
                $sheet->setCellValue('I' . $row, 'Talla: ' . $item['talla']);
                $sheet->setCellValue('K' . $row, ''); // CONSUMO
                $sheet->setCellValue('L' . $row, ''); // DEVOLUTIVO
                $sheet->setCellValue('M' . $row, ''); // SOFTWARE
                $sheet->setCellValue('N' . $row, 'X'); // EPP

                // Aplicar estilos a la fila de datos
                $dataCols = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N'];
                foreach ($dataCols as $col) {
                    $cellStyle = $sheet->getStyle($col . $row);
                    $cellStyle->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                    $cellStyle->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);

                    if (in_array($col, ['C', 'H', 'K', 'L', 'M', 'N'])) {
                        $cellStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    } else {
                        $cellStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    }
                }

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
