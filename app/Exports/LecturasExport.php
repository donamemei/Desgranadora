<?php

namespace App\Exports;

use App\Models\Lectura;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class LecturasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithColumnFormatting
{
    public function __construct(private string $sesionId) {}

    /**
     * Datos a exportar.
     */
    public function collection(): Collection
    {
        return Lectura::deSesion($this->sesionId)
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Encabezados de las columnas en español.
     */
    public function headings(): array
    {
        return [
            '#',
            'Fecha y hora',
            'RPM',
            'Kg procesados',
            'Kg / hora',
            'Temperatura (°C)',
            'Estado motor',
            'Sesión',
        ];
    }

    /**
     * Cómo se mapea cada fila del modelo a las columnas.
     */
    public function map($lectura): array
    {
        static $fila = 0;
        $fila++;

        return [
            $fila,
            $lectura->created_at->format('d/m/Y H:i:s'),
            $lectura->rpm,
            $lectura->kg_procesados,
            $lectura->kg_hora,
            $lectura->temperatura ?? 0,
            $lectura->estado_motor,
            $lectura->sesion_id,
        ];
    }

    /**
     * Estilo de la fila de encabezados.
     */
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '0D6EFD']],
            ],
        ];
    }

    /**
     * Formato numérico de las columnas.
     */
    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_00,    // RPM
            'D' => NumberFormat::FORMAT_NUMBER_00,    // Kg procesados
            'E' => NumberFormat::FORMAT_NUMBER_00,    // Kg/hora
            'F' => NumberFormat::FORMAT_NUMBER_00,    // Temperatura
        ];
    }

    /**
     * Nombre de la hoja del Excel.
     */
    public function title(): string
    {
        return 'Sesión ' . $this->sesionId;
    }
}
