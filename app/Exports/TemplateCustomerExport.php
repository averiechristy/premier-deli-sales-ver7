<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TemplateCustomerExport implements FromCollection, WithHeadings
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
        // Mengembalikan koleksi kosong
        return collect([]);
    }

  
}
