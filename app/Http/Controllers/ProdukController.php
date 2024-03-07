<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\ProductImport;
use App\Models\Produk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function adminprodukindex(){
        $produk = Produk::orderBy('created_at', 'desc')->get();
        return view('adminproduk.produk.index',[
           'produk' => $produk
        ]);
    }

    public function download()
    {
        // Panggil class export Anda, sesuaikan dengan struktur data Anda
        return Excel::download(new TemplateExport(), 'template.xlsx');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');

        Excel::import(new ProductImport, $file);

        $request->session()->flash('success', "Data produk berhasil ditambahkan.");

        return redirect()->route('adminproduk.produk.index');

    }


    public function adminprodukcreate(){
        return view('adminproduk.produk.create');
    }

    public function adminprodukstore(Request $request){

        $kodeproduk = $request->kode_produk;

        $existingcode = Produk::where('kode_produk',$kodeproduk)->first();
       
        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Data gagal disimpan, kode produk yang Anda masukkan sudah ada dalam sistem kami. Harap pastikan untuk menggunakan kode produk yang unik");
            return redirect()->route('adminproduk.produk.index');
        }
        

        $namaproduk = $request->nama_produk;
        $hargabeli = $request->harga_beli;
        $hargajual = $request->harga_jual;


      Produk::create([
          'kode_produk' => $kodeproduk,
          'nama_produk' => $namaproduk,
          'harga_beli' => $hargabeli,
          'harga_jual' => $hargajual,
        ]);

        $request->session()->flash('success', "Data produk berhasil diunggah.");

        return redirect()->route('adminproduk.produk.index');

    }

    public function adminprodukshow($id){
        $data = Produk::find($id);

        return view('adminproduk.produk.edit',[
            'data' => $data,
        ]);
    }

    public function adminprodukupdate(Request $request, $id){
        $data = Produk::find($id);

        $data-> kode_produk = $request-> kode_produk;
        $data-> nama_produk = $request-> nama_produk;
        $data->harga_beli = $request-> harga_beli;
        $data-> harga_jual = $request-> harga_jual;

        $data->save();

        $request->session()->flash('success', "Data produk berhasil diubah");

        return redirect()->route('adminproduk.produk.index');
    }

    public function adminprodukdestroy (Request $request, $id){
        $data = Produk::find($id);
        $data->delete();

        $request->session()->flash('success', "Data produk berhasil dihapus");

        return redirect()->route('adminproduk.produk.index');
    }

    public function index()
    {
        //
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
