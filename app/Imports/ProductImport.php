<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToModel, WithStartRow
{
    private $lastId;

    public function __construct()
    {
        $this->lastId = Produk::latest()->value('id') ?? 0;
    }
        
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {             
        
        $existingProduct = Produk::where('kode_produk', $row['0'])->first();

        if($existingProduct) {
            return null;
        }
        
        $this->lastId++;

        return new Produk([
            'id' => $this->lastId,
            'kode_produk' => $row['0'],
            'nama_produk' => $row['1'],
            'harga_beli' => $row['2'],
            'harga_jual' => $row['3'],
            'kode_supplier' => $row['4'],
            'nama_supplier' => $row['5'],
        ]);

    }
}
