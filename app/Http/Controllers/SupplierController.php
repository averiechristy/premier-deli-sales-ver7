<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function adminprodukindex()
    {

        $supplier = Supplier::orderBy('created_at', 'desc')->get();
        return view ('adminproduk.supplier.index',[
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function adminprodukcreate()
    {
        return view('adminproduk.supplier.create');
    }


    public function adminprodukstore(Request $request)
    {
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $kode = $request->kode_supplier;
        $nama = $request -> nama_supplier;

        $existingcode = Supplier::where('kode_supplier',$kode)->first();

        $existingname = Supplier::where('nama_supplier', $nama)->first();

        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode supplier sudah terdaftar.");
            return redirect()->route('adminproduk.supplier.index');
        }

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Nama supplier sudah terdaftar.");
            return redirect()->route('adminproduk.supplier.index');
        }

        $alamat = $request -> alamat_supplier;

        Supplier::create([
       
            'kode_supplier' => $kode,
            'nama_supplier' => $nama,
            'alamat_supplier' => $alamat,
            'created_by' => $loggedInUsername,
        ]);

        $request->session()->flash('success', 'Supplier berhasil ditambahkan.');

        return redirect(route('adminproduk.supplier.index'));
    }


    public function superadminindex()
    {

        $supplier = Supplier::orderBy('created_at', 'desc')->get();
        return view ('superadmin.supplier.index',[
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function superadmincreate()
    {
        return view('superadmin.supplier.create');
    }


    public function superadminstore(Request $request)
    {
  
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $kode = $request->kode_supplier;
        $nama = $request -> nama_supplier;

        $existingcode = Supplier::where('kode_supplier',$kode)->first();

        $existingname = Supplier::where('nama_supplier', $nama)->first();

        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode supplier sudah terdaftar.");
            return redirect()->route('superadmin.supplier.index');
        }

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Nama supplier sudah terdaftar.");
            return redirect()->route('superadmin.supplier.index');
        }

        $alamat = $request -> alamat_supplier;

        Supplier::create([
       
            'kode_supplier' => $kode,
            'nama_supplier' => $nama,
            'alamat_supplier' => $alamat,
            'created_by' => $loggedInUsername,
        ]);

        $request->session()->flash('success', 'Supplier berhasil ditambahkan.');

        return redirect(route('superadmin.supplier.index'));
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
    public function adminprodukshow(string $id)
    {
        $data = Supplier::find($id);

        return view('adminproduk.supplier.edit',[
           'data' => $data, 
        ]);
    }

    public function superadminshow(string $id)
    {
        $data = Supplier::find($id);

        return view('superadmin.supplier.edit',[
           'data' => $data, 
        ]);
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
    public function adminprodukupdate(Request $request, string $id)
    {

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $data = Supplier::find($id);

        $kode = $request->kode_supplier;
        $nama = $request -> nama_supplier;

        $existingcode = Supplier::where('kode_supplier',$kode)
        ->where('id', '!=', $id)
        ->first();

        $existingname = Supplier::where('nama_supplier', $nama)
        ->where('id', '!=', $id)
        ->first();

        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode supplier sudah terdaftar.");
            return redirect()->route('adminproduk.supplier.index');
        }

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Nama supplier sudah terdaftar.");
            return redirect()->route('adminproduk.supplier.index');
        }


        $data->kode_supplier = $request->kode_supplier;
        $data->nama_supplier = $request->nama_supplier;
        $data->alamat_supplier = $request -> alamat_supplier;
        $data->updated_by = $loggedInUsername;


        $data->save();

        $request->session()->flash('success', 'Supplier berhasil diubah. ');

        return redirect(route('adminproduk.supplier.index'));
    }

    public function superadminupdate(Request $request, string $id)
    {
        $data = Supplier::find($id);
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $kode = $request->kode_supplier;
        $nama = $request -> nama_supplier;

        $existingcode = Supplier::where('kode_supplier',$kode)
        ->where('id', '!=', $id)
        ->first();

        $existingname = Supplier::where('nama_supplier', $nama)
        ->where('id', '!=', $id)
        ->first();

        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode supplier sudah terdaftar.");
            return redirect()->route('superadmin.supplier.index');
        }

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Nama supplier sudah terdaftar.");
            return redirect()->route('superadmin.supplier.index');
        }

        $data->kode_supplier = $request->kode_supplier;
        $data->nama_supplier = $request->nama_supplier;
        $data->alamat_supplier = $request -> alamat_supplier;
        $data->updated_by = $loggedInUsername;

        $data->save();

        $request->session()->flash('success', 'Supplier berhasil diubah. ');

        return redirect(route('superadmin.supplier.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function adminprodukdestroy(Request $request, $id)
    {
        $data = Supplier::find($id);
        if (Produk::where('supplier_id', $data->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus supplier, karena masih ada data produk yang berhubungan");
            return redirect()->route('adminproduk.supplier.index');
        }

        $data->delete();

        $request->session()->flash('success', 'Supplier berhasil dihapus. ');

        return redirect(route('adminproduk.supplier.index'));
    }

    public function superadmindestroy(Request $request, $id)
    {
        $data = Supplier::find($id);

        if (Produk::where('supplier_id', $data->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus supplier, karena masih ada data produk yang berhubungan");
            return redirect()->route('superadmin.supplier.index');
        }

        $data->delete();

        $request->session()->flash('success', 'Supplier berhasil dihapus. ');

        return redirect(route('superadmin.supplier.index'));
    }
}
