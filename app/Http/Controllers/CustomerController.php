<?php

namespace App\Http\Controllers;

use App\Exports\TemplateCustomerExport;
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
     public function downloadtemplatecustomer()
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
    
public function admininvoicecreate(){
    return view ('admininvoice.customer.create');
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
