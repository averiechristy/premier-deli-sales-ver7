<?php

namespace App\Http\Controllers;

use App\Exports\TemplateExport;
use App\Imports\ProductImport;
use App\Models\DetailQuotation;
use App\Models\Produk;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


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

    public function superadminindex(){
        $produk = Produk::orderBy('created_at', 'desc')->get();
        return view('superadmin.produk.index',[
           'produk' => $produk
        ]);
    }


    public function download()
    {
        // Panggil class export Anda, sesuaikan dengan struktur data Anda
        return Excel::download(new TemplateExport(), 'templateproduk.xlsx');
    }
    public function superadmindownload()
    {
        // Panggil class export Anda, sesuaikan dengan struktur data Anda
        return Excel::download(new TemplateExport(), 'templateproduk.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');

            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

            $expectedHeaders = [
                'Kode Supplier',
                'Kode Produk',
                'Nama Produk',
                'Harga Beli',
                'Harga Jual',

            ];
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("File tidak sesuai.");
            }
            $data = Excel::toCollection(new ProductImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("File harus diisi.");

            }
            // Lakukan impor
            Excel::import(new ProductImport, $file);
    
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Produk berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',   $e->getMessage());
        }
    
        return redirect()->route('adminproduk.produk.index');
    }
    public function superadminimport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
          
            $reader = Excel::toArray([], $file);
            $headingRow = $reader[0][0];

            $expectedHeaders = [
                'Kode Supplier',
                'Kode Produk',
                'Nama Produk',
                'Harga Beli',
                'Harga Jual',
              
            ];
    
            if ($headingRow !== $expectedHeaders) {
                throw new Exception("File tidak sesuai.");
            }
            // Lakukan impor
            Excel::import(new ProductImport, $file);
            $data = Excel::toCollection(new ProductImport, $file);

            if ($data->isEmpty() || $data->first()->isEmpty()) {
                throw new Exception("File harus diisi.");

            }
            // Jika impor berhasil, tampilkan pesan sukses
            $request->session()->flash('success', "Produk berhasil ditambahkan.");
        } catch (Exception $e) {
            // Jika terjadi exception, tangkap dan tampilkan pesan kesalahan
            $request->session()->flash('error',  $e->getMessage());
        }
        return redirect()->route('superadmin.produk.index');
    }

    public function adminprodukcreate(){
        $supplier = Supplier::all();

      
        return view('adminproduk.produk.create',[
            'supplier' => $supplier,
        ]);
    }

    public function superadmincreate(){
        $supplier = Supplier::all();
        return view('superadmin.produk.create',[
            'supplier' => $supplier,
        ]);
    }

    public function getProductsBySupplier(Request $request)
    {
        $supplierId = $request->input('supplier_id');
        $datasupplier = Supplier::find($supplierId);
        $kodesupplier = $datasupplier->kode_supplier;
        $products = Produk::where('kode_supplier', $kodesupplier)->get(); // Sesuaikan dengan model dan nama kolom yang sesuai di database Anda
        return response()->json(['products' => $products]);
    }
    public function superadmingetProductsBySupplier(Request $request)
    {
        $supplierId = $request->input('supplier_id');
        $datasupplier = Supplier::find($supplierId);
        $kodesupplier = $datasupplier->kode_supplier;
        $products = Produk::where('kode_supplier', $kodesupplier)->get(); // Sesuaikan dengan model dan nama kolom yang sesuai di database Anda
        return response()->json(['products' => $products]);
    }
    
    public function adminprodukstore(Request $request){

        

        $kodeproduk = $request->kode_produk;
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $existingcode = Produk::where('kode_produk',$kodeproduk)->first();
       
        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode produk sudah terdaftar.");
            return redirect()->route('adminproduk.produk.index');
        }
        
        $namaproduk = $request->nama_produk;
        $hargabeli = $request->harga_beli;
        $hargajual = $request->harga_jual;
   
        $supplierid = $request ->supplier_id;
        $datasupplier = Supplier::find($supplierid);

        $kodesupplier = $datasupplier -> kode_supplier;
        $namasupplier = $datasupplier -> nama_supplier;

        $fileName = null;
        if ($request->has('resized_image') && $request->input('resized_image')) {
        $resizedImage = $request->input('resized_image');
    $image_parts = explode(";base64,", $resizedImage);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);

    // Generate a unique file name
    $fileName = uniqid() . '.' . $image_type;
    $directoryPath = public_path('images/produk/');
    $filePath = $directoryPath . $fileName;

    // Ensure the directory exists
    if (!file_exists($directoryPath)) {
        mkdir($directoryPath, 0755, true);
    }

    // Save the image file
    file_put_contents($filePath, $image_base64);
        }

      

      Produk::create([
          'kode_produk' => $kodeproduk,
          'nama_produk' => $namaproduk,
          'harga_beli' => $hargabeli,
          'harga_jual' => $hargajual,
          'kode_supplier' => $kodesupplier,
          'nama_supplier' => $namasupplier,
          'supplier_id' => $supplierid,
          'created_by' => $loggedInUsername,
          'gambar_produk' => $fileName,
        ]);



        $request->session()->flash('success', "Produk berhasil ditambahkan.");

        return redirect()->route('adminproduk.produk.index');

    }
    public function superadminstore(Request $request){

    

        $kodeproduk = $request->kode_produk;
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $existingcode = Produk::where('kode_produk',$kodeproduk)->first();
       
        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode produk sudah terdaftar.");
            return redirect()->route('superadmin.produk.index');
        }
        
        $namaproduk = $request->nama_produk;
        $hargabeli = $request->harga_beli;
        $hargajual = $request->harga_jual;
   
        $supplierid = $request ->supplier_id;
        $datasupplier = Supplier::find($supplierid);

        $kodesupplier = $datasupplier -> kode_supplier;
        $namasupplier = $datasupplier -> nama_supplier;
        $fileName = null;
        if ($request->has('resized_image') && $request->input('resized_image')) {
        $resizedImage = $request->input('resized_image');
    $image_parts = explode(";base64,", $resizedImage);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    $image_base64 = base64_decode($image_parts[1]);

    // Generate a unique file name
    $fileName = uniqid() . '.' . $image_type;
    $directoryPath = public_path('images/produk/');
    $filePath = $directoryPath . $fileName;

    // Ensure the directory exists
    if (!file_exists($directoryPath)) {
        mkdir($directoryPath, 0755, true);
    }

    // Save the image file
    file_put_contents($filePath, $image_base64);
}

      

      Produk::create([
          'kode_produk' => $kodeproduk,
          'nama_produk' => $namaproduk,
          'harga_beli' => $hargabeli,
          'harga_jual' => $hargajual,
          'kode_supplier' => $kodesupplier,
          'nama_supplier' => $namasupplier,
          'supplier_id' => $supplierid,
          'created_by' => $loggedInUsername,
          'gambar_produk' => $fileName,
        ]);


        $request->session()->flash('success', "Produk berhasil ditambahkan.");

        return redirect()->route('superadmin.produk.index');

    }


    public function adminprodukshow($id){
        $data = Produk::find($id);
        $supplier = Supplier::all();

        return view('adminproduk.produk.edit',[
            'data' => $data,
            'supplier' => $supplier,
        ]);
    }

    public function superadminshow($id){
        $data = Produk::find($id);

        $supplier = Supplier::all();
     

        return view('superadmin.produk.edit',[
            'data' => $data,
            'supplier' => $supplier,
        ]);
    }


    public function adminprodukupdate(Request $request, $id){
     
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $data = Produk::find($id);
        $supplierid = $request ->supplier_id;
        $datasupplier = Supplier::find($supplierid);

        $kodeproduk = $request->kode_produk;

        $existingcode = Produk::where('kode_produk',$kodeproduk)
        ->where('id', '!=', $id)
        ->first();
       
        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode produk sudah terdaftar.");
            return redirect()->route('adminproduk.produk.index');
        }

        $fileName = $data->gambar_produk; // Use existing image as default

        if ($request->has('resized_image') && $request->input('resized_image')) {
            $resizedImage = $request->input('resized_image');
            $image_parts = explode(";base64,", $resizedImage);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
    
            // Generate a unique file name
            $fileName = uniqid() . '.' . $image_type;
            $directoryPath = public_path('images/produk/');
            $filePath = $directoryPath . $fileName;
    
            // Ensure the directory exists
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
    
            // Save the image file
            file_put_contents($filePath, $image_base64);
        }

       
        $kodesupplier = $datasupplier -> kode_supplier;
        $namasupplier = $datasupplier -> nama_supplier;
        $data-> kode_produk = $request-> kode_produk;
        $data-> nama_produk = $request-> nama_produk;
        $data->harga_beli = $request-> harga_beli;
        $data-> harga_jual = $request-> harga_jual;
        $data->updated_by = $loggedInUsername;

        $data->kode_supplier =  $kodesupplier;
        $data->nama_supplier = $namasupplier ;
      $data -> gambar_produk = $fileName;

        $data -> supplier_id = $supplierid;
        $data->save();

        $request->session()->flash('success', "Produk berhasil diubah.");

        return redirect()->route('adminproduk.produk.index');
    }

    
    public function getProductPrice(Request $request)
    {
        $productId = $request->input('product_id');
        
        // Ambil harga produk dari database berdasarkan product_id
        $product = Produk::find($productId);

        // Periksa apakah produk ditemukan
        if ($product) {
            return response()->json(['price' => $product->harga]); // Adjust the attribute name accordingly
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
    public function superadminupdate(Request $request, $id){
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $data = Produk::find($id);
        $supplierid = $request ->supplier_id;
        $datasupplier = Supplier::find($supplierid);

        $kodeproduk = $request->kode_produk;

        $existingcode = Produk::where('kode_produk',$kodeproduk)
        ->where('id', '!=', $id)
        ->first();
       
        if($existingcode !== null && $existingcode) {
            $request->session()->flash('error', "Kode produk sudah terdaftar.");
            return redirect()->route('superadmin.produk.index');
        }

        $fileName = $data->gambar_produk; // Use existing image as default

        if ($request->has('resized_image') && $request->input('resized_image')) {
            $resizedImage = $request->input('resized_image');
            $image_parts = explode(";base64,", $resizedImage);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
    
            // Generate a unique file name
            $fileName = uniqid() . '.' . $image_type;
            $directoryPath = public_path('images/produk/');
            $filePath = $directoryPath . $fileName;
    
            // Ensure the directory exists
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0755, true);
            }
    
            // Save the image file
            file_put_contents($filePath, $image_base64);
        }

       
        $kodesupplier = $datasupplier -> kode_supplier;
        $namasupplier = $datasupplier -> nama_supplier;
        $data-> kode_produk = $request-> kode_produk;
        $data-> nama_produk = $request-> nama_produk;
        $data->harga_beli = $request-> harga_beli;
        $data-> harga_jual = $request-> harga_jual;
        $data->updated_by = $loggedInUsername;

        $data->kode_supplier =  $kodesupplier;
        $data->nama_supplier = $namasupplier ;
      $data -> gambar_produk = $fileName;

        $data -> supplier_id = $supplierid;
        $data->save();
       

        $request->session()->flash('success', "Produk berhasil diubah.");

        return redirect()->route('superadmin.produk.index');
    }
    public function adminprodukdestroy (Request $request, $id){

      
        $data = Produk::find($id);

        if (DetailQuotation::where('product_id', $data->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus produk, karena masih ada data yang berhubungan");

            return redirect()->route('adminproduk.produk.index');
        
        }


        $data->delete();

        $request->session()->flash('success', "Produk berhasil dihapus.");

        return redirect()->route('adminproduk.produk.index');
    }

    public function superadmindestroy (Request $request, $id){
        $data = Produk::find($id);

        
        if (DetailQuotation::where('product_id', $data->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus produk, karena masih ada data yang berhubungan");

            return redirect()->route('superadmin.produk.index');
        
        }
        $data->delete();

        $request->session()->flash('success', "Produk berhasil dihapus.");

        return redirect()->route('superadmin.produk.index');
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
