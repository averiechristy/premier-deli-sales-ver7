<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Produk;
use App\Models\Supplier;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductImport implements ToModel, WithStartRow, WithHeadingRow
{

    
    private $lastId;
    private $allowedSupplier = [];

    public function __construct()
    {
        $this->lastId = Produk::latest()->value('id') ?? 0;
        $this->allowedSupplier = Supplier::pluck('kode_supplier')->toArray();
    }
        
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {             
      
        $expectedHeaders = [
            'kode_produk',
            'nama_produk',
            'harga_beli',
            'harga_jual',
            'kode_supplier',
        ];
    
        // Check if headers match the expected headers
        $diff = array_diff($expectedHeaders, array_keys($row));
        if (!empty($diff)) {
            throw new Exception("Template tidak sesuai");
        }

      
    

        $sup =  $row['kode_supplier'];
       
        if (!in_array($sup, $this->allowedSupplier)) {
            $allowedSupplierStr = implode(', ', $this->allowedSupplier);
            throw new Exception("Supplier $sup tidak valid, hanya boleh $allowedSupplierStr");
        }

        $supplier = Supplier::where('kode_supplier', $row['kode_supplier'])->first();

        $supplierid = $supplier -> id;
        // Jika supplier tidak ditemukan, kembalikan pesan kesalahan
        if (!$supplier) {
           
            throw new Exception('Supplier dengan kode ' . $row['kode_supplier'] . ' tidak ditemukan.');
        }
        
        $existingProduct = Produk::where('kode_produk', $row['kode_produk'])->first();
       

        if($existingProduct) {
            return null;
        }
        
        if (!is_numeric($row['harga_beli'])) {
            throw new Exception('Harga beli harus berupa angka.');
        }
    
        // Periksa apakah harga jual adalah angka
        if (!is_numeric($row['harga_jual'])) {
            throw new Exception('Harga jual harus berupa angka.');
        }

       
        
        $this->lastId++;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama;

        return new Produk([
            'id' => $this->lastId,
            'kode_produk' => $row['kode_produk'],
            'nama_produk' => $row['nama_produk'],
            'harga_beli' => $row['harga_beli'],
            'harga_jual' => $row['harga_jual'],
            'kode_supplier' => $row['kode_supplier'],
            'nama_supplier' => $supplier->nama_supplier,
            'supplier_id' =>  $supplierid,
            'created_by' => $loggedInUsername,
        ]);

    }
}
