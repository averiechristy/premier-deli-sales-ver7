<?php

namespace App\Http\Controllers;

use App\Models\CancelApproval;
use App\Models\Customer;
use App\Models\DetailQuotation;
use App\Models\Produk;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  
    public function salesindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $quotation = Quotation::where('created_by',$userid )->orderBy('created_at', 'desc')->get();
        
        return view ('sales.quotation.index',[
            'quotation' => $quotation,
        ]);
    }

    public function leaderindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $sales = User::where('report_to', $userid)->get();

        $salesIds = $sales->pluck('id')->toArray();
       
        $quote = Quotation::where('created_by',$userid )->orderBy('created_at', 'desc')->get();

        $quotedarisales = Quotation::whereIn('created_by', $salesIds)
        ->orderBy('created_at', 'desc')
        ->get();


       

        return view ('leader.quotation.index',[
            'quotedarisales' => $quotedarisales,
            'quote' => $quote,
        ]);
    }

    public function managerindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $sales = User::where('report_to', $userid)->get();

        $salesIds = $sales->pluck('id')->toArray();
       
        $quote = Quotation::where('created_by',$userid )->orderBy('created_at', 'desc')->get();

        $quotedarisales = Quotation::whereIn('created_by', $salesIds)
        ->orderBy('created_at', 'desc')
        ->get();


       

        return view ('manager.quotation.index',[
            'quotedarisales' => $quotedarisales,
            'quote' => $quote,
        ]);
    }
    public function salescreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

       
        
        $lastquote = Quotation::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $year = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $month = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        $lastOrder = $lastquote ? substr($lastquote->no_quote, 6, 4) : 0; 
        
       // Mendapatkan nomor urutan terakhir dari nomor invoice terakhir
        $orderNumber = 'QUOTE/' . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;
      
       
        return view('sales.createquotation',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    }

    public function leadercreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

       
        
        $lastquote = Quotation::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $year = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $month = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        $lastOrder = $lastquote ? substr($lastquote->no_quote, 6, 4) : 0; 
        
       // Mendapatkan nomor urutan terakhir dari nomor invoice terakhir
        $orderNumber = 'QUOTE/' . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;
      
       
        return view('leader.quotation.create',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    }  
    
    public function managercreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

       
        
        $lastquote = Quotation::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $year = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $month = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        $lastOrder = $lastquote ? substr($lastquote->no_quote, 6, 4) : 0; 
        
       // Mendapatkan nomor urutan terakhir dari nomor invoice terakhir
        $orderNumber = 'QUOTE/' . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/' . $month . '/' . $year;
      
       
        return view('manager.quotation.create',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    } 

    public function download(Request $request, $id)
    {
        // Mengambil sales order dari database berdasarkan ID
        $quote = Quotation::findOrFail($id);
    
        // Menandai bahwa sales order telah diunduh
        $quote->is_download = true;
    
        // Menyimpan sales order tanpa mempengaruhi updated_at
        $quote->save(['timestamps' => false]);
    
        // Mengembalikan respons sebagai JSON jika diperlukan
        return response()->json(['message' => 'Sales order has been downloaded successfully']);
    }

    public function dowleaderdownloadnload(Request $request, $id)
    {
        // Mengambil sales order dari database berdasarkan ID
        $quote = Quotation::findOrFail($id);
    
        // Menandai bahwa sales order telah diunduh
        $quote->is_download = true;
    
        // Menyimpan sales order tanpa mempengaruhi updated_at
        $quote->save(['timestamps' => false]);
    
        // Mengembalikan respons sebagai JSON jika diperlukan
        return response()->json(['message' => 'Sales order has been downloaded successfully']);
    }
     public function cancelquotation(Request $request){
        $quotation = Quotation::orderBy('created_at', 'desc')->get();
        

        $quoteid = $request->quote_id;
        $loggedInUser = auth()->user();
        $quotedata = Quotation::find($request->quote_id);


        if ($quotedata) {
            $quotedata->status_quote = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $quotedata->save();
        }


        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        

        $cancelreq = new CancelApproval;
        $cancelreq -> quote_id = $request->quote_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> id_report = $report;
        $cancelreq -> report_role = $roleid;
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('sales.quotation.index',[
            'quotation' => $quotation,
        ]));

     }
     public function leadercancelquotation(Request $request){
        $quotation = Quotation::orderBy('created_at', 'desc')->get();
        

        $quoteid = $request->quote_id;
        $loggedInUser = auth()->user();
        $quotedata = Quotation::find($request->quote_id);


        if ($quotedata) {
            $quotedata->status_quote = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $quotedata->save();
        }


        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        

        $cancelreq = new CancelApproval;
        $cancelreq -> quote_id = $request->quote_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> id_report = $report;
        $cancelreq -> report_role = $roleid;
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('leader.quotation.index',[
            'quotation' => $quotation,
        ]));

     }
    public function salesstore(Request $request){
     
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $customer = Customer::find($request->customer_id);

        $nama_pic = $customer ->nama_pic;
        $email = $customer -> email;
        $nohp = $customer -> no_hp;
       
        $nama = $loggedInUser -> nama;

        $quote = new Quotation;
        $quote -> no_quote = $request->no_quote;
        $quote -> quote_date = $request -> quote_date;
        $quote -> valid_date = $request -> valid_date;
        $quote -> cust_id = $request -> customer_id;
        $quote -> nama_customer = $request -> nama_customer;
        $quote -> alamat = $request -> alamat;
        $quote -> nama_penerima = $request ->nama_penerima;
        $quote -> shipping_date = $request -> shipping_date;
        $quote -> payment_date = $request -> payment_date;
        $quote -> nama_pic = $nama_pic;
        $quote -> no_hp = $nohp;
        $quote -> email = $email;
        $quote -> status_quote = "Quotation Dibuat";
        $quote -> discount = $request -> discount;
        $quote -> created_by = $userid;
        $quote -> ppn = $request -> ppn;
        $quote -> nama_pembuat = $nama;
        $quote -> is_persen = $request -> inlineRadioOptions;

        $quote -> save();
       
       
       $quotationDetails = [];
           
       if ($request->has('product') && $request->has('quantity')) {
           foreach ($request->product as $index => $productId) {
               $product = Produk::find($productId);
               $qty = $request->quantity[$index];
               $harga = $product -> harga_jual;
               $totalprice = $qty * $harga;
               
               if ($product) {
                   $quotationDetails[] = [
                       'quote_id' => $quote->id,
                       'product_id' => $productId,
                       'qty' => $request->quantity[$index],
                       'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                       'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                       'quote_price' => $product -> harga_jual,
                       'total_price' => $totalprice,
                   ];
               }
           }
           DetailQuotation::insert($quotationDetails); 
       }

       $request->session()->flash('success', "Quotation berhasil dibuat");

       return redirect()->route('sales.quotation.index');

    }

    public function leaderstore(Request $request){
     
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $customer = Customer::find($request->customer_id);

        $nama_pic = $customer ->nama_pic;
        $email = $customer -> email;
        $nohp = $customer -> no_hp;
       
        $nama = $loggedInUser -> nama;

        $quote = new Quotation;
        $quote -> no_quote = $request->no_quote;
        $quote -> quote_date = $request -> quote_date;
        $quote -> valid_date = $request -> valid_date;
        $quote -> cust_id = $request -> customer_id;
        $quote -> nama_customer = $request -> nama_customer;
        $quote -> alamat = $request -> alamat;
        $quote -> nama_penerima = $request ->nama_penerima;
        $quote -> shipping_date = $request -> shipping_date;
        $quote -> payment_date = $request -> payment_date;
        $quote -> nama_pic = $nama_pic;
        $quote -> no_hp = $nohp;
        $quote -> email = $email;
        $quote -> status_quote = "Quotation Dibuat";
        $quote -> discount = $request -> discount;
        $quote -> created_by = $userid;
        $quote -> ppn = $request -> ppn;
        $quote -> nama_pembuat = $nama;
        $quote -> is_persen = $request -> inlineRadioOptions;

        $quote -> save();
       
       
       $quotationDetails = [];
           
       if ($request->has('product') && $request->has('quantity')) {
           foreach ($request->product as $index => $productId) {
               $product = Produk::find($productId);
               $qty = $request->quantity[$index];
               $harga = $product -> harga_jual;
               $totalprice = $qty * $harga;
               
               if ($product) {
                   $quotationDetails[] = [
                       'quote_id' => $quote->id,
                       'product_id' => $productId,
                       'qty' => $request->quantity[$index],
                       'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                       'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                       'quote_price' => $product -> harga_jual,
                       'total_price' => $totalprice,
                   ];
               }
           }
           DetailQuotation::insert($quotationDetails); 
       }

       $request->session()->flash('success', "Quotation berhasil dibuat");

       return redirect()->route('leader.quotation.index');

    }   
    
    public function managerstore(Request $request){
     
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $customer = Customer::find($request->customer_id);

        $nama_pic = $customer ->nama_pic;
        $email = $customer -> email;
        $nohp = $customer -> no_hp;
       
        $nama = $loggedInUser -> nama;

        $quote = new Quotation;
        $quote -> no_quote = $request->no_quote;
        $quote -> quote_date = $request -> quote_date;
        $quote -> valid_date = $request -> valid_date;
        $quote -> cust_id = $request -> customer_id;
        $quote -> nama_customer = $request -> nama_customer;
        $quote -> alamat = $request -> alamat;
        $quote -> nama_penerima = $request ->nama_penerima;
        $quote -> shipping_date = $request -> shipping_date;
        $quote -> payment_date = $request -> payment_date;
        $quote -> nama_pic = $nama_pic;
        $quote -> no_hp = $nohp;
        $quote -> email = $email;
        $quote -> status_quote = "Quotation Dibuat";
        $quote -> discount = $request -> discount;
        $quote -> created_by = $userid;
        $quote -> ppn = $request -> ppn;
        $quote -> nama_pembuat = $nama;
        $quote -> is_persen = $request -> inlineRadioOptions;

        $quote -> save();
       
       
       $quotationDetails = [];
           
       if ($request->has('product') && $request->has('quantity')) {
           foreach ($request->product as $index => $productId) {
               $product = Produk::find($productId);
               $qty = $request->quantity[$index];
               $harga = $product -> harga_jual;
               $totalprice = $qty * $harga;
               
               if ($product) {
                   $quotationDetails[] = [
                       'quote_id' => $quote->id,
                       'product_id' => $productId,
                       'qty' => $request->quantity[$index],
                       'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
                       'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
                       'quote_price' => $product -> harga_jual,
                       'total_price' => $totalprice,
                   ];
               }
           }
           DetailQuotation::insert($quotationDetails); 
       }

       $request->session()->flash('success', "Quotation berhasil dibuat");

       return redirect()->route('manager.quotation.index');

    }   
    
    public function tampilpesananquote($id)
    {
    
       $pesanan = DetailQuotation::with('quotation')->where('quote_id', $id)->get();
       $quote = Quotation::find($id);
       $noquote = $quote->no_quote;
      
       return view('sales.quotation.tampilpesanan',[
           'pesanan' =>$pesanan,
           'noquote' => $noquote,
       ]);

    }

    public function leadertampilpesananquote($id)
    {
    
       $pesanan = DetailQuotation::with('quotation')->where('quote_id', $id)->get();
       $quote = Quotation::find($id);
       $noquote = $quote->no_quote;
      
       return view('leader.quotation.tampilpesanan',[
           'pesanan' =>$pesanan,
           'noquote' => $noquote,
       ]);

    }

    public function managertampilpesananquote($id)
    {
    
       $pesanan = DetailQuotation::with('quotation')->where('quote_id', $id)->get();
       $quote = Quotation::find($id);
       $noquote = $quote->no_quote;
      
       return view('manager.quotation.tampilpesanan',[
           'pesanan' =>$pesanan,
           'noquote' => $noquote,
       ]);

    }
    
    public function tampilquote($id){

        $quote = Quotation::find($id);
        $detailquote = DetailQuotation::with('quotation')->where('quote_id', $id)->get();

        $discountasli = $quote->discount;
        $tipe = $quote->is_persen;

        $subtotal = 0;
        foreach ($detailquote as $detail) {
            $subtotal += $detail->total_price;
        }
    
        if ($tipe == 'persen') {
            $discount =  ($discountasli / 100) * $subtotal;
        } elseif ($tipe == 'amount'){
            $discount = $quote->discount;
        }
    
        $subtotalafterdiscount = $subtotal - $discount;
    
      $ppnpersen = $quote -> ppn;
      
      $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;
    
    
        $total = $subtotalafterdiscount + $ppn;

        return view('sales.quotation.tampilquote',[
            'subtotal' => $subtotal,
            'discount' => $discount,
            'ppn' => $ppn,
            'total' => $total,
           
            'quote' => $quote,
            'detailquote' => $detailquote,
           
            'tipe' => $tipe,
            'discountasli' => $discountasli,
            'ppnpersen' => $ppnpersen,
        ]);

    }
    public function leadertampilquote($id){

        $quote = Quotation::find($id);
        $detailquote = DetailQuotation::with('quotation')->where('quote_id', $id)->get();

        $discountasli = $quote->discount;
        $tipe = $quote->is_persen;

        $subtotal = 0;
        foreach ($detailquote as $detail) {
            $subtotal += $detail->total_price;
        }
    
        if ($tipe == 'persen') {
            $discount =  ($discountasli / 100) * $subtotal;
        } elseif ($tipe == 'amount'){
            $discount = $quote->discount;
        }
    
        $subtotalafterdiscount = $subtotal - $discount;
    
      $ppnpersen = $quote -> ppn;
      
      $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;
    
    
        $total = $subtotalafterdiscount + $ppn;

        return view('leader.quotation.tampilquote',[
            'subtotal' => $subtotal,
            'discount' => $discount,
            'ppn' => $ppn,
            'total' => $total,
           
            'quote' => $quote,
            'detailquote' => $detailquote,
           
            'tipe' => $tipe,
            'discountasli' => $discountasli,
            'ppnpersen' => $ppnpersen,
        ]);

    }
    public function managertampilquote($id){

        $quote = Quotation::find($id);
        $detailquote = DetailQuotation::with('quotation')->where('quote_id', $id)->get();

        $discountasli = $quote->discount;
        $tipe = $quote->is_persen;

        $subtotal = 0;
        foreach ($detailquote as $detail) {
            $subtotal += $detail->total_price;
        }
    
        if ($tipe == 'persen') {
            $discount =  ($discountasli / 100) * $subtotal;
        } elseif ($tipe == 'amount'){
            $discount = $quote->discount;
        }
    
        $subtotalafterdiscount = $subtotal - $discount;
    
      $ppnpersen = $quote -> ppn;
      
      $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;
    
    
        $total = $subtotalafterdiscount + $ppn;

        return view('manager.quotation.tampilquote',[
            'subtotal' => $subtotal,
            'discount' => $discount,
            'ppn' => $ppn,
            'total' => $total,
           
            'quote' => $quote,
            'detailquote' => $detailquote,
           
            'tipe' => $tipe,
            'discountasli' => $discountasli,
            'ppnpersen' => $ppnpersen,
        ]);

    }    public function index()
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
