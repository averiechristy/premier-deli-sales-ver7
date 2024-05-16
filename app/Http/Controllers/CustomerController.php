<?php

namespace App\Http\Controllers;

use App\Exports\TemplateCustomerExport;
use App\Exports\TemplateCustomerExportSA;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\Inovice;
use App\Models\Kategori;
use App\Models\RFO;
use App\Models\SalesOrder;
use App\Models\Sumber;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function admininvoiceindex()
     {
        $customer = Customer::orderBy('created_at', 'desc')->get();
        return view('admininvoice.customer.index',[
            'customer' => $customer,
        ]);
     }
     public function superadminindex()
     {
        $customer = Customer::orderBy('created_at', 'desc')->get();
        return view('superadmin.customer.index',[
            'customer' => $customer,
        ]);
     }

     public function leaderindex()
     {
        $customer = Customer::orderBy('created_at', 'desc')->get();
        return view('leader.customer.index',[
            'customer' => $customer,
        ]);
     }

     public function managerindex()
     {
        $customer = Customer::orderBy('created_at', 'desc')->get();
        return view('manager.customer.index',[
            'customer' => $customer,
        ]);
     }
     public function downloadtemplatecustomer()
     {
         // Panggil class export Anda, sesuaikan dengan struktur data Anda
         return Excel::download(new TemplateCustomerExport(), 'templatecustomer.xlsx');
     }

     public function leaderdownloadtemplatecustomer()
     {
       
         // Panggil class export Anda, sesuaikan dengan struktur data Anda
         return Excel::download(new TemplateCustomerExport(), 'templatecustomer.xlsx');
     }

     
     public function managerdownloadtemplatecustomer()
     {
       
         // Panggil class export Anda, sesuaikan dengan struktur data Anda
         return Excel::download(new TemplateCustomerExport(), 'templatecustomer.xlsx');
     }

     public function superadmindownloadtemplatecustomer()
     {
     
         // Panggil class export Anda, sesuaikan dengan struktur data Anda
         return Excel::download(new TemplateCustomerExport(), 'templatecustomer.xlsx');
     }
     public function importcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

       
        try {
            $file = $request->file('file');
            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

          
            $expectedHeaders = [
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
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("Template tidak sesuai.");
            }
            
            $data = Excel::toCollection(new CustomerImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("Tidak ada data dalam file");

            }
            // Lakukan impor
            Excel::import(new CustomerImport, $file);
    
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Data customer berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',  $e->getMessage());
        }
    
        return redirect()->route('admininvoice.customer.index');
    }

    public function superadminimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

          
            $expectedHeaders = [
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
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("Template tidak sesuai.");
            }
            $data = Excel::toCollection(new CustomerImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("Tidak ada data dalam file");

            }
            // Lakukan impor
            Excel::import(new CustomerImport, $file);
    
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Data customer berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',  $e->getMessage());
        }
        return redirect()->route('superadmin.customer.index');


    }
    
    public function leaderimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

          
            $expectedHeaders = [
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
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("Template tidak sesuai.");
            }
            $data = Excel::toCollection(new CustomerImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("Tidak ada data dalam file");

            }
            Excel::import(new CustomerImport, $file);
    
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Data customer berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',  $e->getMessage());
        }
    
        return redirect()->route('leader.customer.index');
        
    }

    public function managerimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

          
            $expectedHeaders = [
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
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("Template tidak sesuai.");
            }
            $data = Excel::toCollection(new CustomerImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("Tidak ada data dalam file");
            }
            
            // Lakukan impor
            Excel::import(new CustomerImport, $file);
    
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Data customer berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',  $e->getMessage());
        }
    
        return redirect()->route('manager.customer.index');

    }
public function admininvoicecreate(){
    return view ('admininvoice.customer.create');
}

public function superadmincreate(){
    $kategori = Kategori::all();
    $sumber = Sumber::all();
    return view ('superadmin.customer.create',[
        'kategori' => $kategori,
        'sumber' => $sumber
    ]);
}

public function leadercreate(){
    $kategori = Kategori::all();
    $sumber = Sumber::all();
    return view ('leader.customer.create',[
        'kategori' => $kategori,
        'sumber' => $sumber
    ]);
}

public function managercreate(){

    $kategori = Kategori::all();
    $sumber = Sumber::all();

    return view ('manager.customer.create',[
        'kategori' => $kategori,
        'sumber' => $sumber
    ]);
}

public function admininvoicedestroy(Request $request, $id){

    $datacust = Customer::find($id);

 
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('admininvoice.customer.index');
}

public function superadmindestroy(Request $request, $id){
    
    $datacust = Customer::find($id);

    if (RFO::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
        return redirect()->route('superadmin.customer.index');
    }

    if (SalesOrder::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
        return redirect()->route('superadmin.customer.index');
    }

    if (Inovice::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
        return redirect()->route('superadmin.customer.index');
    }
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('superadmin.customer.index');
}

public function leaderdestroy(Request $request, $id){
    $datacust = Customer::find($id);
    if (RFO::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('leader.customer.index');

    }

    if (SalesOrder::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('leader.customer.index');

    }

    if (Inovice::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('leader.customer.index');

    }
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('leader.customer.index');
}

public function managerdestroy(Request $request, $id){
    $datacust = Customer::find($id);
    if (RFO::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('manager.customer.index');

    }

    if (SalesOrder::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('manager.customer.index');

    }

    if (Inovice::where('cust_id', $datacust->id)->exists()) {
        $request->session()->flash('error', "Tidak dapat menghapus Customer, karena masih ada data  yang berhubungan");
            return redirect()->route('manager.customer.index');

    }
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('manager.customer.index');
}

public function superadminstore(Request $request){
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $namacustomer = $request->nama_customer;
    $kategori = $request->kategori;
    $sumber = $request->sumber;
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();

    $kategoriid = $request->kategori;
    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;


    $datasumber = Sumber::find($sumberid);

    $sumber = $datasumber -> sumber;

    if($existingdata){
        $request->session()->flash('error', "Gagal menyimpan data, nama customer sudah ada.");

        return redirect()->route('superadmin.customer.index');
    }

    Customer::create([
        'nama_customer' => $namacustomer,
        'kategori' => $kategori,
        'sumber' => $sumber,
        'nama_pic' => $namapic,
        'jabatan_pic' => $jabatanpic,
        'no_hp' => $nohp,
        'email' => $email,
        'lokasi' => $lokasi,
        'produk_sebelumnya' => $request->produk_sebelumnya,
        'kategori_id' => $kategoriid,
        'sumber_id' => $sumberid,
        'created_by' => $loggedInUsername,
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('superadmin.customer.index');
}
public function leaderstore(Request $request){
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $namacustomer = $request->nama_customer;
  
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();

    $kategoriid = $request->kategori;
    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;


    $datasumber = Sumber::find($sumberid);

    $sumber = $datasumber -> sumber;

    if($existingdata){
        $request->session()->flash('error', "Gagal menyimpan data, nama customer sudah ada.");

        return redirect()->route('superadmin.customer.index');
    }
    Customer::create([
        'nama_customer' => $namacustomer,
        'kategori' => $kategori,
        'sumber' => $sumber,
        'nama_pic' => $namapic,
        'jabatan_pic' => $jabatanpic,
        'no_hp' => $nohp,
        'email' => $email,
        'lokasi' => $lokasi,
        'produk_sebelumnya' => $request->produk_sebelumnya,
        'kategori_id' => $kategoriid,
        'sumber_id' => $sumberid,
        'created_by' => $loggedInUsername,
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('leader.customer.index');
}

public function managerstore(Request $request){
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $namacustomer = $request->nama_customer;
    $kategoriid = $request->kategori;
  
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();


    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;


    $datasumber = Sumber::find($sumberid);

    $sumber = $datasumber -> sumber;


    if($existingdata){
        $request->session()->flash('error', "Gagal menyimpan data, nama customer sudah ada.");

        return redirect()->route('superadmin.customer.index');
    }
    Customer::create([
        'nama_customer' => $namacustomer,
        'kategori' => $kategori,
        'sumber' => $sumber,
        'nama_pic' => $namapic,
        'jabatan_pic' => $jabatanpic,
        'no_hp' => $nohp,
        'email' => $email,
        'lokasi' => $lokasi,
        'produk_sebelumnya' => $request->produk_sebelumnya,
        'kategori_id' => $kategoriid,
        'sumber_id' => $sumberid,
        'created_by' => $loggedInUsername,
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('manager.customer.index');
}
public function admininvoicestore(Request $request){


    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $namacustomer = $request->nama_customer;
    $kategori = $request->kategori;
    $sumber = $request->sumber;
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;

    $existingdata = Customer::where('nama_customer', $namacustomer)->get();

    if($existingdata){
        $request->session()->flash('error', "Gagal menyimpan data, nama customer sudah ada.");

        return redirect()->route('admininvoice.customer.index');
    }

    Customer::create([
        'nama_customer' => $namacustomer,
        'kategori' => $kategori,
        'sumber' => $sumber,
        'nama_pic' => $namapic,
        'jabatan_pic' => $jabatanpic,
        'no_hp' => $nohp,
        'email' => $email,
        'lokasi' => $lokasi,
        'produk_sebelumnya' => $request->produk_sebelumnya,
        'created_by' => $loggedInUsername,
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('admininvoice.customer.index');
}



public  function admininvoiceshow($id){
    $data = Customer::find($id);

    $kategori = Kategori::all();

    $sumber = Sumber::all();
    return view ('admininvoice.customer.edit',[
        'data' => $data,
        'kategori' => $kategori,
        'sumber' => $sumber,
    ]);

}
public  function superadminshow($id){
    $data = Customer::find($id);
    $sumber = Sumber::all();
    $kategori = Kategori::all();
    return view ('superadmin.customer.edit',[
        'data' => $data,
        'kategori' => $kategori,
        'sumber' => $sumber,
    ]);

}


public  function leadershow($id){
    $data = Customer::find($id);
    $sumber = Sumber::all();
    
      $kategori = Kategori::all();
    return view ('leader.customer.edit',[
        'data' => $data,
        'kategori' => $kategori,
        'sumber' => $sumber,
    ]);

}


public  function managershow($id){
    $data = Customer::find($id);
    $sumber = Sumber::all();
    $kategori = Kategori::all();

    return view ('manager.customer.edit',[
        'data' => $data,
        'kategori' => $kategori,
        'sumber' => $sumber,
    ]);

}
public function admininvoiceupdate(Request $request, $id)
{     $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $data = Customer::find($id);
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $request->kategori;
    $data -> sumber = $request->sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;
    $data->produk_sebelumnya = $request->produk_sebelumnya;
$data -> updated_by = $loggedInUsername;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diubah.");

    return redirect()->route('admininvoice.customer.index');
}

public function superadminupdatecustomer(Request $request, $id)
{  
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
    $data = Customer::find($id);

    $kategoriid = $request->kategori;
    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;


    $datasumber = Sumber::find($sumberid);
    $sumber = $datasumber -> sumber;

    $data->nama_customer = $request->nama_customer;
    $data->kategori = $kategori;
    $data -> sumber = $sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;
    $data->produk_sebelumnya = $request->produk_sebelumnya;
    $data ->updated_by = $loggedInUsername;
   
    $data -> kategori_id = $kategoriid;
    $data -> sumber_id = $sumberid;
    $data->save();
    $request->session()->flash('success', "Data customer berhasil diubah.");

     return redirect()->route('superadmin.customer.index');
}


public function leaderupdatecustomer(Request $request, $id)
{  
    $data = Customer::find($id);

    $kategoriid = $request->kategori;
    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 

    $datasumber = Sumber::find($sumberid);

    $sumber = $datasumber -> sumber;
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $kategori;
    $data -> sumber = $sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;
    $data->produk_sebelumnya = $request->produk_sebelumnya;
    $data -> kategori_id = $kategoriid;
    $data -> sumber_id = $sumberid;

    $data-> updated_by = $loggedInUsername;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diubah.");

    return redirect()->route('leader.customer.index');
}

public function managerupdatecustomer(Request $request, $id)
{  
    $data = Customer::find($id);
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 

    $kategoriid = $request->kategori;
    $sumberid = $request -> sumber;

    $datakategori = Kategori::find($kategoriid);

    $kategori = $datakategori -> kategori;


    $datasumber = Sumber::find($sumberid);

    $sumber = $datasumber -> sumber;

    $data->nama_customer = $request->nama_customer;
    $data->kategori = $kategori;
    $data -> sumber = $sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;
    $data->produk_sebelumnya = $request->produk_sebelumnya;
    $data -> kategori_id = $kategoriid;
    $data -> sumber_id = $sumberid;
    $data -> updated_by = $loggedInUsername;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diubah.");

    return redirect()->route('manager.customer.index');
}
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
