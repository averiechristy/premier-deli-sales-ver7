<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Produk;
use App\Models\Supplier;
use Exception;
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
        $supplier = Supplier::where('kode_supplier', $row['4'])->first();
      

        // Jika supplier tidak ditemukan, kembalikan pesan kesalahan
        if (!$supplier) {
           
            throw new Exception('Supplier dengan kode ' . $row['4'] . ' tidak ditemukan.');
        }
        
        $existingProduct = Produk::where('kode_produk', $row['0'])->first();

        if($existingProduct) {
            return null;
        }
        
        if (!is_numeric($row['2'])) {
            throw new Exception('Harga beli harus berupa angka.');
        }
    
        // Periksa apakah harga jual adalah angka
        if (!is_numeric($row['3'])) {
            throw new Exception('Harga jual harus berupa angka.');
        }

        
        $this->lastId++;

        return new Produk([
            'id' => $this->lastId,
            'kode_produk' => $row['0'],
            'nama_produk' => $row['1'],
            'harga_beli' => $row['2'],
            'harga_jual' => $row['3'],
            'kode_supplier' => $row['4'],
            'nama_supplier' => $supplier->nama_supplier,
        ]);

    }
}
