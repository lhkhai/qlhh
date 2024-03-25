<?php

namespace App\Exports;

use App\Models\product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Font;
/* use Maatwebsite\Excel\Concerns\ShouldAutoSize; */ //đặt độ rộng tự động
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
class ProductsExport implements FromCollection,WithHeadings,WithMapping, WithEvents//WithStyles //ShouldAutoSize,WithStyles,
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }
     public function map($row): array
    {
        static $index = 0;
        $index++;
        return [
            $index,
            $row->masp,
            $row->tensp,
            $row->tennhom,
            $row->chatlieu,
            $row->donvi,
            $row->kichthuoc,
            $row->soluong,
            $row->giaban
        ];
    } 
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Set the width of specific columns
               
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(50);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(10);
                $event->sheet->getDelegate()->getStyle('F')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('G')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // Set width for other columns as needed
                $event->sheet->getDelegate()->getStyle('C')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A1:I1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '6b6c6e',
                        ],
                    ],
                    'font' => [
                        'color' => [
                            'rgb' => 'white', 
                        ],
                        'bold'=>true,
                        'size'=>13,
                        'name'=>'Times New Roman'
                    ],
                ]);
                $event->sheet->getDelegate()->getStyle('A1:I' . ($event->sheet->getDelegate()->getHighestRow()))
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }

    public function headings(): array
    {
        return ['STT','Mã Sản phẩm', 'Tên Sản phẩm', 'Nhóm Sản phẩm','Chất liệu','Đơn vị tính','Size','SL tồn','Giá bán'];
    } 

     
}
