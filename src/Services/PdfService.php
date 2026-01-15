<?php
declare(strict_types=1);

namespace App\Services;

use Dompdf\Dompdf;

class PdfService
{
    public static function generateEmpresasReport(array $empresas, ?string $search = null): void
    {
        $total = count($empresas);
        $fecha = date('Y-m-d H:i:s');
        $searchText = $search ? " (Filtro: {$search})" : '';

        $html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { color: #333; font-size: 18px; margin-bottom: 5px; }
        .meta { color: #666; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #4a90d9; color: white; padding: 8px; text-align: left; }
        td { border: 1px solid #ddd; padding: 6px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 20px; text-align: center; color: #666; font-size: 10px; }
    </style>
</head>
<body>
    <h1>Reporte de Empresas' . htmlspecialchars($searchText) . '</h1>
    <div class="meta">
        Fecha de generación: ' . $fecha . '<br>
        Total de registros: ' . $total . '
    </div>
    <table>
        <tr>
            <th>ID</th>
            <th>RIF</th>
            <th>Razón Social</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Fecha Creación</th>
        </tr>';

        foreach ($empresas as $e) {
            $html .= '<tr>
                <td>' . $e['id_empresa'] . '</td>
                <td>' . htmlspecialchars($e['rif']) . '</td>
                <td>' . htmlspecialchars($e['razon_social']) . '</td>
                <td>' . htmlspecialchars($e['direccion']) . '</td>
                <td>' . htmlspecialchars($e['telefono']) . '</td>
                <td>' . $e['fecha_creacion'] . '</td>
            </tr>';
        }

        $html .= '</table>
    <div class="footer">Generado automáticamente - Sistema CRUD Empresas MVC</div>
</body>
</html>';

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('reporte_empresas.pdf', ['Attachment' => true]);
    }
}
