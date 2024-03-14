<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CustomerImport implements ToModel, WithStartRow
{
    /**
    * @param Collection $collection
    */
    private $lastId;

    public function __construct()
    {
        $this->lastId = Customer::latest()->value('id') ?? 0;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {            
       
        
        $existingcust = Customer::where('nama_customer', $row['0'])->first();

        if($existingcust) {
            // Jika produk dengan kode yang sama sudah ada, Anda dapat memilih untuk melewatinya atau melakukan tindakan lain.
            // Di sini, saya akan mengembalikan null agar produk tidak disimpan kembali.
            return null;
        }
        
        $this->lastId++;

        return new Customer([
            'id' => $this->lastId,
            'nama_customer' => $row['0'],
            'kategori' => $row['1'],
            'sumber' => $row['2'],
            'nama_pic' => $row['3'],
            'jabatan_pic' => $row['4'],
            'no_hp' => $row['5'],
            'email' => $row['6'],
            'lokasi' => $row['7'],
            'produk_sebelumnya' => $row['8'],
        ]);

    }
}
