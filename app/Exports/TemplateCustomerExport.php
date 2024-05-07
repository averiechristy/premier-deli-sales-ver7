<?php
namespace App\Exports;

use App\Models\Kategori;
use App\Models\Sumber;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Protection;


class TemplateCustomerExport implements FromCollection, WithHeadings, WithEvents
{
    public function headings(): array
    {
        return [
            'Nama Customer',
            'Kategori',
            'Sumber',
            'Nama PIC',
            'Jabatan PIC',
            'No Hp',
            'Email',
            'Alamat',
            'Produk yang digunakan sebelumnya',
        ];
    }

    public function collection()
    {
        
        return collect([]);
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                
                $event->sheet->getStyle('1:100000')->getProtection()->setLocked(false);
                $sheet->getStyle('A1:XFD1')->getProtection()->setLocked(Protection::PROTECTION_PROTECTED);
    
                $sheet->getProtection()->setSheet(true);
                
                $categories = Kategori::pluck('kategori')->toArray();
            
                $validation = $event->sheet->getDataValidation('B2:B100000'); // Sesuaikan dengan rentang sel yang sesuai
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
           
                $validation->setFormula1('"' . implode(',', $categories) . '"');

                $sumber = Sumber::pluck('sumber')->toArray();
                $validationSumber = $event->sheet->getDataValidation('C2:C100000'); // Sesuaikan dengan rentang sel yang sesuai
                $validationSumber->setType(DataValidation::TYPE_LIST);
                $validationSumber->setErrorStyle(DataValidation::STYLE_STOP);
                $validationSumber->setAllowBlank(false);
                $validationSumber->setShowInputMessage(true);
                $validationSumber->setShowErrorMessage(true);
                $validationSumber->setShowDropDown(true);
                $validationSumber->setErrorTitle('Input error');
                $validationSumber->setError('Value is not in list.');
           
                $validationSumber->setFormula1('"' . implode(',', $sumber) . '"');

            },
        ];
    }
}
