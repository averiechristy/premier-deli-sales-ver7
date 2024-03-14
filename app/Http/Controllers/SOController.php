<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailRFO;
use App\Models\DetailSO;
use App\Models\Produk;
use App\Models\RFO;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class SOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
public function admininvoiceindex(){

    $so = SalesOrder::orderBy('created_at', 'desc')->get();


    return view ('admininvoice.so.index',[
        'so' => $so,
    ]);
}
    public function admininvoicecreate($id)
    {
        $data = RFO::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $rfo = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastSO = SalesOrder::latest()->first(); // Mendapatkan data SO terakhir dari database
        
        $yearMonth = now()->format('ym'); // Mendapatkan format tahun dan bulan saat ini tanpa empat digit pertama (tahun)
        $lastOrder = $lastSO ? substr($lastSO->no_so, 4) : 0; // Mendapatkan nomor urutan terakhir dari nomor SO terakhir
        
        $orderNumber = $yearMonth . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT); // Menggabungkan tahun, bulan, dan urutan
        
       
        
        return view ('admininvoice.so.create',[
            'data' => $data,
            'rfo' => $rfo,
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber
        ]);

    }

    public function admininvoicestore(Request $request){
      

        $custid = $request -> cust_id;

        $customer = Customer::find($custid);

        $namacust = $customer->nama_customer;

        $rfo = RFO::find($request->rfo_id);
      
        $so = new SalesOrder;


        $so -> no_so = $request -> no_so;
        $so -> cust_id = $request -> cust_id;
        $so -> nama_customer = $namacust;
        $so -> alamat = $request -> alamat;
        $so -> so_date = $request-> so_date;
        $so -> rfo_id = $request-> rfo_id;
        $so -> discount = $request -> discount;
        $so -> no_rfo = $rfo -> no_rfo;
        $so -> ppn = $request -> ppn;
        $so -> pembayaran = $request -> pembayaran;
        $so -> is_persen = $request -> inlineRadioOptions;
        $so -> status_so = "PO Belum Dikerjakan";

        $so -> save();

        if ($rfo) {
            $rfo->status_rfo = 'Terbit SO'; // Ganti dengan status yang sesuai
            $rfo->save();
        }
    
        
        $soDetails = [];


        if ($request->has('product') && $request->has('quantity') && $request->has('price')) {
            foreach ($request->product as $index => $productId) {
                $product = Produk::find($productId); // Mendapatkan data produk dari basis data

                $qty = $request->quantity[$index];
                $harga = $product -> harga_jual;
                $totalprice = $qty * $harga;

                if ($product) {
                    $soDetails[] = [
                        'so_id' => $so->id,
                        'product_id' => $productId,
                        'qty' => $request->quantity[$index],
                        'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                        'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                        'so_price' => $product->harga_jual, // Menyimpan kode_produk
                        'total_price' => $totalprice,
                    ];
                }
            }
            DetailSO::insert($soDetails); 
            
          
        }

        $request->session()->flash('success', "Sales Order berhasil dibuat");

        return redirect()->route('admininvoice.so.index');
    }

    public function tampilso($id){

        $so = SalesOrder::find($id);
        $detailso = DetailSO::with('salesorder')->where('so_id', $id)->get();

        $discountasli = $so->discount;
        $tipe = $so->is_persen;

      
        
    $subtotal = 0;
    foreach ($detailso as $detail) {
        $subtotal += $detail->total_price;
    }

    if ($tipe == 'persen') {
        $discount =  ($discountasli / 100) * $subtotal;
    } elseif ($tipe == 'amount'){
        $discount = $so->discount;
    }

    $subtotalafterdiscount = $subtotal - $discount;

  $ppnpersen = $so -> ppn;
  
  $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;


    $pembayaran = $so->pembayaran;

    $total = $subtotalafterdiscount + $ppn;
    

    $sisatagihan = $total - $pembayaran;


        return view('admininvoice.so.tampilso',[
            'subtotal' => $subtotal,
            'discount' => $discount,
            'ppn' => $ppn,
            'total' => $total,
            'sisatagihan' => $sisatagihan,
            'so' => $so,
            'detailso' => $detailso,
            'pembayaran' => $pembayaran,
            'tipe' => $tipe,
            'discountasli' => $discountasli,
            'ppnpersen' => $ppnpersen,
        ]);
    }


    public function showrfo() {
        $rfo = RFO::where('status_rfo', 'Request Terkirim')->orderBy('created_at', 'desc')->get();
        return view('admininvoice.so.showrfo',[
            'rfo' => $rfo,
        ]);
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
