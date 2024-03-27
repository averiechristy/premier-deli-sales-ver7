<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class TemplateExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Kode Produk',
            'Nama Produk',
            'Harga Beli',
            'Harga Jual',
            'Kode Supplier',
          
        ];
    }

    public function collection()
    {
        // Mengembalikan koleksi kosong
        return collect([]);
    }

  
}
