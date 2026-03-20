<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarPedidosJob;
use App\Models\Pedido;
use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoEnviadoAdmin;
use App\Mail\PedidosAgrupadosAdmin;
use Illuminate\Support\Facades\Log;

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
     * Obtener resumen consolidado de pedidos del área del líder (AJAX)
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
     * Exportar a Excel formato GFPI-F-186 (Formato oficial SENA)
     */
    public function exportarGFPIF186()
    {
        try {
            $user = Auth::user();
            $areaId = $user->areas_id;

            // 1. Obtención de datos con relaciones
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

            // 2. Consolidación de datos detallada
            $consolidado = [];
            foreach ($pedidos as $pedido) {
                $instructor = $pedido->usuario->nombre_completo ?? 'N/A';
                $ficha = $pedido->ficha->numero ?? 'N/A';

                foreach ($pedido->elementos as $elemento) {
                    $clave = $elemento->nombre . '|' . ($elemento->pivot->talla ?? 'Sin talla');

                    if (!isset($consolidado[$clave])) {
                        $consolidado[$clave] = [
                            'nombre' => $elemento->nombre,
                            'talla' => $elemento->pivot->talla ?? 'Sin talla',
                            'cantidad_total' => 0,
                            'descripcion' => $elemento->descripcion ?? '-',
                            'solicitantes' => []
                        ];
                    }

                    $consolidado[$clave]['cantidad_total'] += $elemento->pivot->cantidad;

                    // Rastrear quién solicitó y para qué ficha
                    $infoSolicitud = $instructor . " (Ficha: " . $ficha . ")";
                    if (!isset($consolidado[$clave]['solicitantes'][$infoSolicitud])) {
                        $consolidado[$clave]['solicitantes'][$infoSolicitud] = 0;
                    }
                    $consolidado[$clave]['solicitantes'][$infoSolicitud] += $elemento->pivot->cantidad;
                }
            }

            // 3. Creación del Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Materiales');

            // 4. Configuración de Columnas
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

            // 5. Estilos Reutilizables
            $fontArial14Bold = ['font' => ['bold' => true, 'size' => 14, 'name' => 'Arial']];
            $fontArial11Bold = ['font' => ['bold' => true, 'size' => 11, 'name' => 'Arial']];
            $fontArial10BoldWhite = [
                'font' => ['bold' => true, 'size' => 10, 'name' => 'Arial', 'color' => ['argb' => 'FFFFFFFF']]
            ];

            $alignCenterCenter = [
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true
                ]
            ];

            $borderThin = [
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                ]
            ];

            $fillGray = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE9ECEF']
                ]
            ];

            $fillGreenSena = [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF39A900']
                ]
            ];

            // 6. Encabezados del Formato
            $sheet->mergeCells('M2:O2');
            $sheet->setCellValue('M2', 'Versión: 01');
            $sheet->getStyle('M2:O2')->applyFromArray($fontArial14Bold)->applyFromArray($alignCenterCenter);

            $sheet->mergeCells('M3:O3');
            $sheet->setCellValue('M3', 'Código: GFPI-F-186');
            $sheet->getStyle('M3:O3')->applyFromArray($fontArial14Bold)->applyFromArray($alignCenterCenter);

            $sheet->mergeCells('B4:O4');
            $sheet->setCellValue('B4', 'PROCEDIMIENTO DISEÑO CURRICULAR ');
            $sheet->getStyle('B4:O4')->applyFromArray($fontArial14Bold)->applyFromArray($alignCenterCenter)->applyFromArray($borderThin);

            $sheet->mergeCells('B5:O5');
            $sheet->setCellValue('B5', 'FORMATO ANEXO LISTA DE MATERIALES DE FORMACIÓN REFERENTE');
            $sheet->getStyle('B5:O5')->applyFromArray($fontArial14Bold)->applyFromArray($alignCenterCenter)->applyFromArray($borderThin);

            // 7. Sección Información General
            $sheet->mergeCells('C6:D6');
            $sheet->setCellValue('C6', 'RED DE CONOCIMIENTO - INSTITUCIONAL');
            $sheet->getStyle('C6:D6')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('E6:F6');
            $sheet->setCellValue('E6', 'SENA');
            $sheet->getStyle('E6:F6')->applyFromArray($borderThin);

            $sheet->mergeCells('H6:J6');
            $sheet->setCellValue('H6', 'CÓDIGO DE PROGRAMA DE FORMACIÓN ');
            $sheet->getStyle('H6:J6')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('K6:N6');
            $sheet->setCellValue('K6', 'N/A');
            $sheet->getStyle('K6:N6')->applyFromArray($borderThin);

            $sheet->mergeCells('C7:D7');
            $sheet->setCellValue('C7', 'NIVEL DE FORMACIÓN ');
            $sheet->getStyle('C7:D7')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('E7:F7');
            $sheet->setCellValue('E7', 'TÉCNICO');
            $sheet->getStyle('E7:F7')->applyFromArray($borderThin);

            $sheet->mergeCells('H7:J7');
            $sheet->setCellValue('H7', 'DENOMINACIÓN PROGRAMA DE FORMACIÓN ');
            $sheet->getStyle('H7:J7')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('K7:N7');
            $sheet->setCellValue('K7', $pedidos->first()->ficha->programa->nombre ?? 'No asignado');
            $sheet->getStyle('K7:N7')->applyFromArray($borderThin);

            $sheet->mergeCells('C8:D8');
            $sheet->setCellValue('C8', 'VERSIÓN PROGRAMA DE FORMACIÓN ');
            $sheet->getStyle('C8:D8')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('E8:F8');
            $sheet->setCellValue('E8', '1');
            $sheet->getStyle('E8:F8')->applyFromArray($borderThin);

            $sheet->mergeCells('H8:J8');
            $sheet->setCellValue('H8', 'NOMBRE GESTOR DE RED');
            $sheet->getStyle('H8:J8')->applyFromArray($fontArial11Bold)->applyFromArray($fillGray)->applyFromArray($borderThin);

            $sheet->mergeCells('K8:N8');
            $sheet->setCellValue('K8', $user->nombre_completo);
            $sheet->getStyle('K8:N8')->applyFromArray($borderThin);

            // 8. Encabezados de la Tabla (Fila 11)
            $headers = [
                'C' => 'ÍTEM', 'D' => 'CÓDIGO UNSPSC', 'E' => 'PRODUCTO ',
                'F' => 'DESCRIPCION TÉCNICA REQUERIDA DEL BIEN ', 'G' => 'UNIDAD DE MEDIDA ',
                'H' => 'CANTIDAD REQUERIDA PARA FORMAR 30 APRENDICES DURANTE LA FORMACIÓN',
                'I' => 'OBSERVACIONES', 'K' => 'CONSUMO', 'L' => 'DEVOLUTIVO',
                'M' => 'SOFTWARE', 'N' => 'EPP'
            ];

            foreach ($headers as $col => $text) {
                $sheet->setCellValue($col . '11', $text);
                $sheet->getStyle($col . '11')
                    ->applyFromArray($fontArial10BoldWhite)
                    ->applyFromArray($alignCenterCenter)
                    ->applyFromArray($fillGreenSena)
                    ->applyFromArray($borderThin);
            }

            // 9. Datos de la Tabla (Fila 13 en adelante)
            $row = 13;
            $numero = 1;

            foreach ($consolidado as $item) {
                $obsText = "TALLA: " . strtoupper($item['talla']) . "\n\nSOLICITADO POR:\n";
                foreach ($item['solicitantes'] as $info => $cant) {
                    $obsText .= "• " . $info . ": " . $cant . " Unid.\n";
                }

                $sheet->setCellValue('C' . $row, $numero);
                $sheet->setCellValue('D' . $row, ''); // UNSPSC
                $sheet->setCellValue('E' . $row, $item['nombre']);
                $sheet->setCellValue('F' . $row, $item['descripcion']);
                $sheet->setCellValue('G' . $row, 'UNIDAD');
                $sheet->setCellValue('H' . $row, $item['cantidad_total']);
                $sheet->setCellValue('I' . $row, $obsText);
                $sheet->setCellValue('K' . $row, '');
                $sheet->setCellValue('L' . $row, '');
                $sheet->setCellValue('M' . $row, '');
                $sheet->setCellValue('N' . $row, 'X');

                $cols = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'K', 'L', 'M', 'N'];
                foreach ($cols as $col) {
                    $style = $sheet->getStyle($col . $row);
                    $style->applyFromArray($borderThin);
                    $style->getAlignment()->setVertical(Alignment::VERTICAL_TOP)->setWrapText(true);

                    if (in_array($col, ['C', 'H', 'K', 'L', 'M', 'N'])) {
                        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    } else {
                        $style->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                    }
                }

                $numero++;
                $row++;
            }

            // 10. Descarga del Archivo
            $writer = new Xlsx($spreadsheet);
            $filename = 'GFPI-F-186_' . str_replace(' ', '_', $user->area->nombre ?? 'Area') . '_' . now()->format('d-m-Y') . '.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;

        } catch (\Exception $e) {
            \Log::error('Error Exportar Excel: ' . $e->getMessage());
            return back()->with('error', 'Error al generar el archivo Excel.');
        }
    }

    /**
     * Enviar un pedido al administrador
     */
    public function enviarPedido($id)
    {
        try {
            $pedido = Pedido::with(['usuario.area', 'elementos', 'ficha.programa'])->findOrFail($id);
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

            // --- ENVÍO DE CORREO ---
            $adminEmail = config('mail.from.address'); // O el correo específico del administrador
            Mail::to($adminEmail)->send(new PedidoEnviadoAdmin($pedido, $user->area->nombre ?? 'Área desconocida'));

            return redirect()->back()->with('success', 'Pedido enviado y correo notificado correctamente');
        } catch (\Exception $e) {
            \Log::error('Error al enviar pedido: ' . $e->getMessage());
            return redirect()->back()->with('success', 'Pedido enviado, pero hubo un problema con la notificación por correo.');
        }
    }

    /**
     * Enviar todos los pedidos pendientes
     */
   public function enviarTodos()
{
    $user = Auth::user();

    EnviarPedidosJob::dispatch($user);

    return back()->with('success', 'Los pedidos se están procesando en segundo plano');
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
