<?php
namespace App\Imports;

use App\Models\Customer;
use App\Models\Kategori;
use App\Models\Sumber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Session;

class CustomerImport implements ToModel, WithStartRow, WithHeadingRow
{
    private $lastId;
    private $allowedCategories = [];
    
    private $allowedSumber = [];

    
    public function __construct()
    {
        $this->lastId = Customer::latest()->value('id') ?? 0;
        $this->allowedCategories = Kategori::pluck('kategori')->toArray();

        $this->allowedSumber = Sumber::pluck('sumber')->toArray();
    }

    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {            

        $expectedHeaders = [
            'nama_customer',
            'kategori',
            'sumber',
            'nama_pic',
            'jabatan_pic',
            'no_hp',
            'email',
            'alamat',
            'produk_yang_digunakan_sebelumnya'
        ];
    
        $diff = array_diff($expectedHeaders, array_keys($row));
        if (!empty($diff)) {
            throw new \Exception("File tidak sesuai.");
        }

        $nohp = $row['no_hp'];
        if (!is_numeric($nohp)) {
            throw new \Exception("Format no handphone $nohp tidak valid.");
        }
        
        // Validasi format email
        $email = $row['email'];
       
        if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("Format email $email tidak valid.");
        }
        
        $kategori = $row['kategori'];

        if (!in_array($kategori, $this->allowedCategories)) {
            $allowedCategoriesStr = implode(', ', $this->allowedCategories);
            throw new \Exception("Kategori $kategori tidak valid.");
        }

        $sumber = $row['sumber'];

        if (!in_array($sumber, $this->allowedSumber)) {
            $allowedSumberStr = implode(', ', $this->allowedCategories);
            throw new \Exception("Sumber $sumber tidak valid.");
        }

        $datakategori = Kategori::where('kategori', $kategori)->first();

        $kategoriid = $datakategori -> id;

        $datasumber = Sumber::where('sumber', $sumber)->first();
        $sumberid = $datasumber->id;

       
       
        
        

        $existingCust = Customer::where('nama_customer', $row['nama_customer'])->first();

        if ($existingCust) {
            return null;
        }
        
        $this->lastId++;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 


        return new Customer([
            'id' => $this->lastId,
            'nama_customer' => $row['nama_customer'],
            'kategori' => $row['kategori'],
            'sumber' => $row['sumber'],
            'nama_pic' => $row['nama_pic'],
            'jabatan_pic' => $row['jabatan_pic'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'lokasi' => $row['alamat'],
            'produk_sebelumnya' => $row['produk_yang_digunakan_sebelumnya'],
            'kategori_id' => $kategoriid,
            'sumber_id' => $sumberid,
            'created_by' => $loggedInUsername,
        ]);
    }
}
