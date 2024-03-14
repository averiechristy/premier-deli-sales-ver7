<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailRFO;
use App\Models\Produk;
use App\Models\RFO;
use Illuminate\Http\Request;

class RFOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function salescreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastRFO = RFO::latest()->first(); // Mendapatkan data SO terakhir dari database

        $yearMonth = now()->format('ym'); // Mendapatkan format tahun dan bulan saat ini tanpa empat digit pertama (tahun)
        $lastOrder = $lastRFO ? substr($lastRFO->no_rfo, -4) : '0000'; // Mengambil empat digit terakhir dari nomor SO terakhir
        
        $orderNumber = 'RFO - ' . $yearMonth . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT); // Menggabungkan tahun, bulan, dan urutan
        
        
      
       
        return view('sales.createrfo',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    }

    public function salesstore(Request $request){
       
        $rfo = new RFO;
        $rfo -> nama_penerima = $request->nama_penerima;
        $rfo -> no_rfo = $request->no_rfo;
        $rfo -> tanggal_order = $request->order_date;
        $rfo->cust_id = $request->customer_id;
        $rfo->nama_customer = $request->nama_customer;
        $rfo->alamat = $request->alamat;
        $rfo->shipping_date = $request->shipping_date;
        $rfo ->payment_date = $request -> payment_date;
        $rfo->status_rfo = "Request Terkirim";

        $rfo -> save();

        $rfoDetails = [];

        
       

        if ($request->has('product') && $request->has('quantity')) {
            foreach ($request->product as $index => $productId) {
                $product = Produk::find($productId); // Mendapatkan data produk dari basis data
                if ($product) {
                    $rfoDetails[] = [
                        'rfo_id' => $rfo->id,
                        'product_id' => $productId,
                        'qty' => $request->quantity[$index],
                        'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                        'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                        'harga_jual' => $product -> harga_jual,
                    ];
                }
            }
            DetailRFO::insert($rfoDetails); 
        }
        
        $request->session()->flash('success', "Pesanan berhasil dikirim");

        return redirect()->route('sales.dashboard');
        
    }

    public function admininvoiceindex(){
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        return view ('admininvoice.rfo.index',[
    'rfo' => $rfo,]);
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
