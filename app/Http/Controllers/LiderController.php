<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
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
     * Obtener resumen consolidado del área del líder
     */
    public function resumenConsolidado()
    {
        $user = Auth::user();

        if (!$user->areas_id) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no tiene área asignada'
            ], 400);
        }

        $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
            $query->where('areas_id', $user->areas_id);
        })->with('elementos')->get();

        if ($pedidos->isEmpty()) {
            return response()->json([
                'success' => false,
                'consolidado' => [],
                'total_pedidos' => 0,
                'total_unidades' => 0
            ]);
        }

        $consolidado = [];
        $totalUnidades = 0;

        foreach ($pedidos as $pedido) {
            foreach ($pedido->elementos as $elemento) {
                $talla = $elemento->pivot->talla ?? 'Sin talla';
                $cantidad = $elemento->pivot->cantidad ?? 1;
                $nombre = $elemento->nombre;
                $key = "{$nombre}_{$talla}";

                if (isset($consolidado[$key])) {
                    $consolidado[$key]['cantidad_total'] += $cantidad;
                } else {
                    $consolidado[$key] = [
                        'nombre' => $nombre,
                        'talla' => $talla,
                        'cantidad_total' => $cantidad,
                        'codigo_unspsc' => $elemento->codigo_unspsc ?? null,
                        'descripcion_tecnica' => $elemento->descripcion_tecnica ?? null,
                        'unidad_medida' => $elemento->unidad_medida ?? 'Unidad'
                    ];
                }
                $totalUnidades += $cantidad;
            }
        }

        $consolidado = array_values($consolidado);

        return response()->json([
            'success' => true,
            'consolidado' => $consolidado,
            'total_pedidos' => $pedidos->count(),
            'total_unidades' => $totalUnidades,
            'area' => $user->area->nombre ?? 'No asignada'
        ]);
    }

    /**
     * Exportar consolidación a Excel GFPI-F-186
     */
    public function exportarGFPIF186()
    {
        try {
            $user = Auth::user();

            if (!$user->areas_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no tiene área asignada'
                ], 400);
            }

            $pedidos = Pedido::whereHas('usuario', function ($query) use ($user) {
                $query->where('areas_id', $user->areas_id);
            })->with(['elementos', 'ficha.programa', 'usuario'])->get();

            // Obtener información del programa
            $programa = null;
            $ficha = null;
            $red = null;
            $nivel = null;
            $version = null;
            $instructores = [];
            $lider = $user;

            if ($pedidos->isNotEmpty()) {
                foreach ($pedidos as $pedido) {
                    if ($pedido->usuario && $pedido->usuario->nombre_completo) {
                        $instructores[$pedido->usuario->id] = $pedido->usuario->nombre_completo;
                    }

                    if (!$programa && $pedido->ficha) {
                        $ficha = $pedido->ficha;
                        if ($ficha->programa) {
                            $programa = $ficha->programa;
                            $red = $programa->red ?? 'SENA';
                            $nivel = $programa->nivel ?? 'TÉCNICO';
                            $version = $programa->version ?? '1.0';
                        }
                    }
                }
            }

            // Consolidar elementos
            $consolidado = [];
            $totalUnidades = 0;

            foreach ($pedidos as $pedido) {
                foreach ($pedido->elementos as $elemento) {
                    $talla = $elemento->pivot->talla ?? 'Sin talla';
                    $cantidad = $elemento->pivot->cantidad ?? 1;
                    $nombre = $elemento->nombre;
                    $key = "{$nombre}_{$talla}";

                    if (isset($consolidado[$key])) {
                        $consolidado[$key]['cantidad_total'] += $cantidad;
                    } else {
                        $consolidado[$key] = [
                            'nombre' => $nombre,
                            'talla' => $talla,
                            'cantidad_total' => $cantidad,
                            'codigo_unspsc' => $elemento->codigo_unspsc ?? null,
                            'descripcion_tecnica' => $elemento->descripcion_tecnica ?? null,
                            'unidad_medida' => $elemento->unidad_medida ?? 'Unidad'
                        ];
                    }
                    $totalUnidades += $cantidad;
                }
            }

            $consolidado = array_values($consolidado);

            // Crear Excel
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Materiales');

            // Estilos
            $titleStyle = [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            ];

            $subtitleStyle = [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            ];

            $labelStyle = [
                'font' => ['bold' => true, 'size' => 10],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
            ];

            $valueStyle = [
                'font' => ['size' => 10],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
            ];

            $headerStyle = [
                'font' => ['bold' => true, 'size' => 10, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF406479']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'border' => [
                    'top' => ['style' => Border::BORDER_THIN],
                    'left' => ['style' => Border::BORDER_THIN],
                    'bottom' => ['style' => Border::BORDER_THIN],
                    'right' => ['style' => Border::BORDER_THIN]
                ]
            ];

            $dataStyle = [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_TOP, 'wrapText' => true],
                'border' => [
                    'top' => ['style' => Border::BORDER_THIN],
                    'left' => ['style' => Border::BORDER_THIN],
                    'bottom' => ['style' => Border::BORDER_THIN],
                    'right' => ['style' => Border::BORDER_THIN]
                ]
            ];

            $centerStyle = [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true],
                'border' => [
                    'top' => ['style' => Border::BORDER_THIN],
                    'left' => ['style' => Border::BORDER_THIN],
                    'bottom' => ['style' => Border::BORDER_THIN],
                    'right' => ['style' => Border::BORDER_THIN]
                ]
            ];

            // Configurar ancho de columnas
            $sheet->getColumnDimension('A')->setWidth(2);
            $sheet->getColumnDimension('B')->setWidth(8);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(25);
            $sheet->getColumnDimension('F')->setWidth(35);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(12);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(12);
            $sheet->getColumnDimension('K')->setWidth(12);
            $sheet->getColumnDimension('L')->setWidth(12);
            $sheet->getColumnDimension('M')->setWidth(12);

            // Encabezado
            $sheet->setCellValue('L1', 'Versión: 01');
            $sheet->getStyle('L1')->applyFromArray($labelStyle);

            $sheet->setCellValue('L2', 'Código: GFPI-F-186');
            $sheet->getStyle('L2')->applyFromArray($labelStyle);

            $sheet->mergeCells('B3:M3');
            $sheet->setCellValue('B3', 'PROCEDIMIENTO DISEÑO CURRICULAR');
            $sheet->getStyle('B3')->applyFromArray($titleStyle);
            $sheet->getRowDimension(3)->setRowHeight(25);

            $sheet->mergeCells('B4:M4');
            $sheet->setCellValue('B4', 'FORMATO ANEXO LISTA DE MATERIALES DE FORMACIÓN REFERENTE');
            $sheet->getStyle('B4')->applyFromArray($subtitleStyle);
            $sheet->getRowDimension(4)->setRowHeight(20);

            // Información del programa
            $sheet->setCellValue('B6', 'RED DE CONOCIMIENTO - INSTITUCIONAL');
            $sheet->getStyle('B6')->applyFromArray($labelStyle);
            $sheet->setCellValue('C6', $red ?? '');
            $sheet->getStyle('C6')->applyFromArray($valueStyle);

            $sheet->setCellValue('G6', 'CÓDIGO DE PROGRAMA DE FORMACIÓN');
            $sheet->getStyle('G6')->applyFromArray($labelStyle);
            $sheet->setCellValue('H6', $programa->codigo ?? '');
            $sheet->getStyle('H6')->applyFromArray($valueStyle);

            $sheet->setCellValue('B7', 'NIVEL DE FORMACIÓN');
            $sheet->getStyle('B7')->applyFromArray($labelStyle);
            $sheet->setCellValue('C7', $nivel ?? '');
            $sheet->getStyle('C7')->applyFromArray($valueStyle);

            $sheet->setCellValue('G7', 'DENOMINACIÓN PROGRAMA DE FORMACIÓN');
            $sheet->getStyle('G7')->applyFromArray($labelStyle);
            $sheet->mergeCells('H7:M7');
            $sheet->setCellValue('H7', $programa->nombre ?? '');
            $sheet->getStyle('H7')->applyFromArray($valueStyle);

            $sheet->setCellValue('B8', 'VERSIÓN');
            $sheet->getStyle('B8')->applyFromArray($labelStyle);
            $sheet->setCellValue('C8', $version ?? '');
            $sheet->getStyle('C8')->applyFromArray($valueStyle);

            $sheet->setCellValue('G8', 'FICHA ASIGNADA');
            $sheet->getStyle('G8')->applyFromArray($labelStyle);
            $sheet->setCellValue('H8', $ficha->numero ?? '');
            $sheet->getStyle('H8')->applyFromArray($valueStyle);

            $sheet->getRowDimension(9)->setRowHeight(5);

            // Responsables
            $sheet->setCellValue('B10', 'INSTRUCTOR(ES) SOLICITANTE(S)');
            $sheet->getStyle('B10')->applyFromArray($labelStyle);
            $instructoresText = !empty($instructores) ? implode(', ', $instructores) : 'No especificado';
            $sheet->mergeCells('C10:F10');
            $sheet->setCellValue('C10', $instructoresText);
            $sheet->getStyle('C10')->applyFromArray($valueStyle);

            $sheet->setCellValue('G10', 'LÍDER DEL ÁREA');
            $sheet->getStyle('G10')->applyFromArray($labelStyle);
            $sheet->mergeCells('H10:M10');
            $sheet->setCellValue('H10', $lider->nombre_completo ?? $lider->name ?? 'No especificado');
            $sheet->getStyle('H10')->applyFromArray($valueStyle);

            $sheet->setCellValue('B11', 'FECHA DE GENERACIÓN');
            $sheet->getStyle('B11')->applyFromArray($labelStyle);
            $sheet->setCellValue('C11', now()->format('d/m/Y H:i'));
            $sheet->getStyle('C11')->applyFromArray($valueStyle);

            // Encabezados de tabla
            $headers = ['ÍTEM', 'CÓDIGO UNSPSC', 'PRODUCTO', 'DESCRIPCIÓN TÉCNICA REQUERIDA DEL BIEN', 'UNIDAD DE MEDIDA', 'CANTIDAD REQUERIDA PARA FORMAR 30 APRENDICES DURANTE LA FORMACIÓN', 'OBSERVACIONES', 'CONSUMO', 'DEVOLUTIVO', 'SOFTWARE', 'EPP'];
            $cols = ['B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];

            foreach ($cols as $idx => $col) {
                $sheet->setCellValue($col . '13', $headers[$idx]);
                $sheet->getStyle($col . '13')->applyFromArray($headerStyle);
            }

            $sheet->getRowDimension(13)->setRowHeight(30);

            // Datos de materiales
            $row = 14;
            $item = 1;

            foreach ($consolidado as $material) {
                $sheet->setCellValue('B' . $row, $item);
                $sheet->setCellValue('C' . $row, $material['codigo_unspsc'] ?? '');
                $sheet->setCellValue('D' . $row, $material['nombre']);
                $sheet->setCellValue('E' . $row, $material['descripcion_tecnica'] ?? '');
                $sheet->setCellValue('F' . $row, $material['unidad_medida']);
                $sheet->setCellValue('G' . $row, $material['cantidad_total']);
                $sheet->setCellValue('H' . $row, '');
                $sheet->setCellValue('I' . $row, '');
                $sheet->setCellValue('J' . $row, '');
                $sheet->setCellValue('K' . $row, '');
                $sheet->setCellValue('L' . $row, 'X');

                for ($col = 'B'; $col <= 'L'; $col++) {
                    if ($col === 'B' || $col === 'G' || $col === 'L') {
                        $sheet->getStyle($col . $row)->applyFromArray($centerStyle);
                    } else {
                        $sheet->getStyle($col . $row)->applyFromArray($dataStyle);
                    }
                }

                $sheet->getRowDimension($row)->setRowHeight(25);
                $row++;
                $item++;
            }

            // Generar archivo
            $writer = new Xlsx($spreadsheet);
            $areaName = $user->area->nombre ?? 'Área';
            $programaName = $programa->nombre ?? 'Programa';
            $filename = 'GFPI-F-186_' . str_replace(' ', '_', $areaName) . '_' . str_replace(' ', '_', $programaName) . '_' . now()->format('d-m-Y_H-i-s') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');

            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            \Log::error('Error en exportarGFPIF186: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al generar el archivo: ' . $e->getMessage()
            ], 500);
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

        foreach ($pedidos as $pedido) {
            $pedido->update(['estado' => 'enviado']);
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
