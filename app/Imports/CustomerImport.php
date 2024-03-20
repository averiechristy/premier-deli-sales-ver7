<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;

class CustomerImport implements ToModel, WithStartRow
{
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
        // Validasi format email

        $existingCust = Customer::where('nama_customer', $row['0'])->first();

        if ($existingCust) {
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
