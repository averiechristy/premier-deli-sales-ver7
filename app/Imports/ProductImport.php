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
            'kode_supplier',
            'kode_produk',
            'nama_produk',
            'harga_beli',
            'harga_jual',
           
        ];
    
        // Check if headers match the expected headers
        $diff = array_diff($expectedHeaders, array_keys($row));
        if (!empty($diff)) {
            throw new Exception("File tidak sesuai");
        }

      
    

        $sup =  $row['kode_supplier'];
       
        if (!in_array($sup, $this->allowedSupplier)) {
            $allowedSupplierStr = implode(', ', $this->allowedSupplier);
            throw new Exception("Supplier $sup tidak valid.");
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
        
        $hargabeli = $row['harga_beli'];

        $hargajual = $row['harga_jual'];

        if (!is_numeric($row['harga_beli'])) {
            throw new Exception("Format harga beli $hargabeli tidak valid.");
        }
    
        // Periksa apakah harga jual adalah angka
        if (!is_numeric($row['harga_jual'])) {
            throw new Exception("Format harga jual $hargajual tidak valid.");
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
