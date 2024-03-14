<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\DetailSO;
use App\Models\Inovice;
use App\Models\Produk;
use App\Models\RFO;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admininvoiceindex(){

        $invoice = Inovice::orderBy('created_at', 'desc')->get();
    
    
        return view ('admininvoice.invoice.index',[
            'invoice' => $invoice,
        ]);
    }
     public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */


     public function admininvoicecreate($id)
     {
        $data = SalesOrder::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $so = DetailSO::with('salesorder')->where('so_id', $id)->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastInvoice = Inovice::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $year = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $month = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        $lastOrder = $lastInvoice ? substr($lastInvoice->invoice_no, 4, 4) : 0; 
       // Mendapatkan nomor urutan terakhir dari nomor invoice terakhir
        $invoicenumber = 'INV/' . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year; // Menggabungkan nomor invoice dengan tahun dan bulan

        $discountasli = $data->discount;
        $tipe = $data->is_persen;

      
        
    $subtotal = 0;
    foreach ($so as $detail) {
        $subtotal += $detail->total_price;
    }

    if ($tipe == 'persen') {
        $discount =  ($discountasli / 100) * $subtotal;
    } elseif ($tipe == 'amount'){
        $discount = $data->discount;
    }

    $subtotalafterdiscount = $subtotal - $discount;



  $ppnpersen = $data -> ppn;
  
  $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;


    $pembayaran = $data->pembayaran;

    $total = $subtotalafterdiscount + $ppn;
    

    $sisatagihan = $total - $pembayaran;
 
  
        
        return view('admininvoice.invoice.create',[
            'invoicenumber' => $invoicenumber,
            'data' => $data,
            'customer' => $customer,
            'produk' => $produk,
            'so' => $so,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'ppn' => $ppn,
            'total' => $total,
            'sisatagihan' => $sisatagihan,
            'pembayaran' => $pembayaran,
            'tipe' => $tipe,
            'discountasli' => $discountasli,
           
        ]);
     }

public function tampilinvoice($id){
    $invoice = Inovice::find($id);
    $detailinvoice = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();

   

    return view('admininvoice.invoice.tampilinvoice',[
        'invoice' => $invoice,
        'detailinvoice' => $detailinvoice,
    ]);
}



     public function admininvoicestore(Request $request)
     {
    
     
        $custid = $request -> cust_id;

        $customer = Customer::find($custid);

        $namacust = $customer->nama_customer;

        $so = SalesOrder::find($request->so_id);
        $so->status_so = "Terbit Invoice";
        $so->save();
    
        // 2. Dari so_id, ambil rfo_id dan update status_rfo menjadi "Terbit Invoice"
        $rfo_id = $so->rfo_id;
        $rfo = RFO::find($rfo_id);
        $rfo->status_rfo = "Terbit Invoice";
        $rfo->save();

        $invoice = new Inovice;
        $invoice->so_id = $request->so_id;
        $invoice->invoice_no = $request -> invoice_no;
        $invoice->invoice_date = $request -> invoice_date;
        $invoice -> cust_id = $request -> cust_id;
        $invoice -> nama_customer = $namacust;
        $invoice -> no_so = $so->no_so;
        $invoice -> alamat = $request -> alamat;
        $invoice -> subtotal = $request -> subtotal;
        $invoice -> is_persen = $request->is_persen;
        $invoice -> discount = $request -> discount;
        $invoice -> ppn = $request -> ppn;
        $invoice -> total = $request->total;

       
        $invoice -> save();

        $invoiceDetails = [];

        if ($request->has('product') && $request->has('quantity') && $request->has('price') && $request->has('totalprice')) {
            foreach ($request->product as $index => $productId) {
                $product = Produk::find($productId); // Mendapatkan data produk dari basis data

                $qty = $request->quantity[$index];
                $harga = $product -> harga_jual;
                $totalprice = $qty * $harga;

                if ($product) {
                    $invoiceDetails[] = [
                        'invoice_id' => $invoice->id,
                        'product_id' => $productId,
                        'qty' => $request->quantity[$index],
                        'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                        'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                        'invoice_price' => $product->harga_jual, // Menyimpan kode_produk
                        'total_price' => $totalprice,
                    ];
                }
            }
            DetailInvoice::insert($invoiceDetails); 
            
          
        }

        $request->session()->flash('success', "Invoice berhasil dibuat");

        return redirect()->route('admininvoice.invoice.index');
     }
     public function showso()
     {
        $so = SalesOrder::where('status_so','Terbit PO')->orderBy('created_at', 'desc')->get();
        return view('admininvoice.invoice.showso',[
            'so' => $so,
        ]);
     }
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
