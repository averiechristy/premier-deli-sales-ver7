<?php

namespace App\Http\Controllers;

use App\Exports\TemplateCustomerExport;
use App\Exports\TemplateCustomerExportSA;
use App\Imports\CustomerImport;
use App\Models\Customer;
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

        $file = $request->file('file');

        Excel::import(new CustomerImport, $file);

        $request->session()->flash('success', "Data customer berhasil ditambahkan.");

        return redirect()->route('admininvoice.customer.index');

    }

    public function superadminimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new CustomerImport, $file);

        $request->session()->flash('success', "Data customer berhasil ditambahkan.");

        return redirect()->route('superadmin.customer.index');

    }
    
    public function leaderimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new CustomerImport, $file);

        $request->session()->flash('success', "Data customer berhasil ditambahkan.");

        return redirect()->route('leader.customer.index');

    }

    public function managerimportcustomer(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new CustomerImport, $file);

        $request->session()->flash('success', "Data customer berhasil ditambahkan.");

        return redirect()->route('manager.customer.index');

    }
public function admininvoicecreate(){
    return view ('admininvoice.customer.create');
}

public function superadmincreate(){
    return view ('superadmin.customer.create');
}

public function leadercreate(){
    return view ('leader.customer.create');
}

public function managercreate(){
    return view ('manager.customer.create');
}

public function admininvoicedestroy(Request $request, $id){

    $datacust = Customer::find($id);
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('admininvoice.customer.index');
}

public function superadmindestroy(Request $request, $id){
    
    $datacust = Customer::find($id);
    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('superadmin.customer.index');
}

public function leaderdestroy(Request $request, $id){
    $datacust = Customer::find($id);

    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('leader.customer.index');
}

public function managerdestroy(Request $request, $id){
    $datacust = Customer::find($id);

    $datacust->delete();
    $request->session()->flash('success', "Data customer berhasil dihapus.");

    return redirect()->route('manager.customer.index');
}

public function superadminstore(Request $request){

    $namacustomer = $request->nama_customer;
    $kategori = $request->kategori;
    $sumber = $request->sumber;
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();

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
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('superadmin.customer.index');
}
public function leaderstore(Request $request){

    $namacustomer = $request->nama_customer;
    $kategori = $request->kategori;
    $sumber = $request->sumber;
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();

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
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('leader.customer.index');
}
public function managerstore(Request $request){

    $namacustomer = $request->nama_customer;
    $kategori = $request->kategori;
    $sumber = $request->sumber;
    $namapic = $request->nama_pic;
    $jabatanpic = $request->jabatan_pic;
    $nohp = $request->no_hp;
    $email = $request->email;
    $lokasi = $request->lokasi;
    $existingdata = Customer::where('nama_customer', $namacustomer)->first();

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
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('manager.customer.index');
}
public function admininvoicestore(Request $request){



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
      ]);
    

      $request->session()->flash('success', "Data customer berhasil ditambahkan.");

      return redirect()->route('admininvoice.customer.index');
}



public  function admininvoiceshow($id){
    $data = Customer::find($id);

    
    return view ('admininvoice.customer.edit',[
        'data' => $data,
    ]);

}
public  function superadminshow($id){
    $data = Customer::find($id);

    
    return view ('leader.customer.edit',[
        'data' => $data,
    ]);

}


public  function leadershow($id){
    $data = Customer::find($id);

    
    return view ('leader.customer.edit',[
        'data' => $data,
    ]);

}


public  function managershow($id){
    $data = Customer::find($id);

    
    return view ('manager.customer.edit',[
        'data' => $data,
    ]);

}
public function admininvoiceupdate(Request $request, $id)
{  
    $data = Customer::find($id);
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $request->kategori;
    $data -> sumber = $request->sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diupdate.");

    return redirect()->route('admininvoice.customer.index');
}

public function superadminupdatecustomer(Request $request, $id)
{  
    $data = Customer::find($id);
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $request->kategori;
    $data -> sumber = $request->sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diupdate.");

    return redirect()->route('superadmin.customer.index');
}


public function leaderupdatecustomer(Request $request, $id)
{  
    $data = Customer::find($id);
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $request->kategori;
    $data -> sumber = $request->sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diupdate.");

    return redirect()->route('leader.customer.index');
}

public function managerupdatecustomer(Request $request, $id)
{  
    $data = Customer::find($id);
    $data->nama_customer = $request->nama_customer;
    $data->kategori = $request->kategori;
    $data -> sumber = $request->sumber;
    $data -> nama_pic = $request->nama_pic;
    $data -> jabatan_pic = $request-> jabatan_pic;
    $data -> no_hp = $request->no_hp;
    $data -> email = $request->email;
    $data -> lokasi = $request -> lokasi;

    $data->save();
    $request->session()->flash('success', "Data customer berhasil diupdate.");

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
