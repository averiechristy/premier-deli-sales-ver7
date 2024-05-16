<?php

namespace App\Http\Controllers;

use App\Models\CancelApprovalSA;
use App\Models\Customer;
use App\Models\DetailInvoice;
use App\Models\DetailQuotation;
use App\Models\DetailRFO;
use App\Models\DetailSO;
use App\Models\DetailSoPo;
use App\Models\Inovice;
use App\Models\Produk;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RFO;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function updateinvoice($id, Request $request){
        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
     
        $invid = $request->invoice_id;

        $detailinv = DetailInvoice::where('invoice_id', $invid)->get();

        $datainvoice = Inovice::find($invid);

        $soid = $datainvoice->so_id;
        $quoteid = $datainvoice -> quote_id;

        $datainvoice -> invoice_date = $request -> invoice_date;
        $datainvoice -> updated_by = $loggedInUsername;
        $datainvoice -> save();

        if($quoteid){
        
            $dataquote = Quotation::find($quoteid);
            $detailquote = DetailQuotation::where('quote_id', $quoteid)->get();
            
            $produkIdsInDetailInv = $detailinv->pluck('product_id')->toArray();

            $produk = $request->product;
    
    // Mengumpulkan id_produk dari $produk yang diterima melalui permintaan
    $produkIdsRequested = collect($produk)->pluck('id')->toArray();
    
    // Mencari id_produk yang berbeda antara produk pada detail invoice dan produk yang diterima melalui permintaan
    $differentProdukIds = array_diff($produkIdsInDetailInv, $produk);

    
    // Jika Anda ingin mendapatkan informasi lebih lanjut tentang produk yang berbeda, Anda dapat melakukan sesuatu seperti ini:
    $differentProduk = Produk::whereIn('id', $differentProdukIds)->get();
    
    // Sekarang Anda dapat melakukan apa pun yang Anda inginkan dengan $differentProduk
    
  
    if (!empty($differentProdukIds)) {
       
        foreach ($detailinv as $detail) {
            if (in_array($detail->product_id, $differentProdukIds)) {
            
                $detail->delete();
            }
        }
        foreach ($detailquote as $detail) {
            if (in_array($detail->product_id, $differentProdukIds)) {
                $detail->keterangan ="Cancelled";
                $detail->save();
            }
        }
    
    
    }
        }
      
        if($soid){
       
        $dataso = SalesOrder::find($soid);

    
        $rfoid = $dataso -> rfo_id;

        $detailso = DetailSO::where('so_id', $soid)->get();

        $detailrfo = DetailRFO::where('rfo_id', $rfoid)->get();

       
        $produk = $request->product;

        $produkIdsInDetailInv = $detailinv->pluck('product_id')->toArray();

// Mengumpulkan id_produk dari $produk yang diterima melalui permintaan
$produkIdsRequested = collect($produk)->pluck('id')->toArray();

// Mencari id_produk yang berbeda antara produk pada detail invoice dan produk yang diterima melalui permintaan
$differentProdukIds = array_diff($produkIdsInDetailInv, $produk);

// Jika Anda ingin mendapatkan informasi lebih lanjut tentang produk yang berbeda, Anda dapat melakukan sesuatu seperti ini:
$differentProduk = Produk::whereIn('id', $differentProdukIds)->get();

// Sekarang Anda dapat melakukan apa pun yang Anda inginkan dengan $differentProduk

if (!empty($differentProdukIds)) {
    foreach ($detailinv as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
        
            $detail->delete();
        }
    }
    foreach ($detailso as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
            $detail->keterangan ="Cancelled";
            $detail->save();
        }
    }
    foreach ($detailrfo as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
            $detail->keterangan ="Cancelled";
            $detail->save();
        }
    }


}

}


$request->session()->flash('success', "Invoice berhasil diubah.");

return redirect()->route('admininvoice.invoice.index');
     }

     public function superadminupdateinvoice($id, Request $request){
     
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $invid = $request->invoice_id;

        $detailinv = DetailInvoice::where('invoice_id', $invid)->get();

        $datainvoice = Inovice::find($invid);

        $soid = $datainvoice->so_id;
        $quoteid = $datainvoice -> quote_id;

        $datainvoice -> invoice_date = $request -> invoice_date;
        $datainvoice -> updated_by = $loggedInUsername;
        $datainvoice -> save();

        if($quoteid){

            $dataquote = Quotation::find($quoteid);
            $detailquote = DetailQuotation::where('quote_id', $quoteid)->get();

            $produk = $request->product;

            $produkIdsInDetailInv = $detailinv->pluck('product_id')->toArray();
    
    // Mengumpulkan id_produk dari $produk yang diterima melalui permintaan
    $produkIdsRequested = collect($produk)->pluck('id')->toArray();
    
    // Mencari id_produk yang berbeda antara produk pada detail invoice dan produk yang diterima melalui permintaan
    $differentProdukIds = array_diff($produkIdsInDetailInv, $produk);
    
    // Jika Anda ingin mendapatkan informasi lebih lanjut tentang produk yang berbeda, Anda dapat melakukan sesuatu seperti ini:
    $differentProduk = Produk::whereIn('id', $differentProdukIds)->get();
    
    // Sekarang Anda dapat melakukan apa pun yang Anda inginkan dengan $differentProduk
    
    
    if (!empty($differentProdukIds)) {
        foreach ($detailinv as $detail) {
            if (in_array($detail->product_id, $differentProdukIds)) {
            
                $detail->delete();
            }
        }
        foreach ($detailquote as $detail) {
            if (in_array($detail->product_id, $differentProdukIds)) {
                $detail->keterangan ="Cancelled";
                $detail->save();
            }
        }
    
    
    }
        }

        if($soid){
       

        $dataso = SalesOrder::find($soid);

       

        $rfoid = $dataso -> rfo_id;

        $detailso = DetailSO::where('so_id', $soid)->get();

        $detailrfo = DetailRFO::where('rfo_id', $rfoid)->get();

       

        $produk = $request->product;

        $produkIdsInDetailInv = $detailinv->pluck('product_id')->toArray();

// Mengumpulkan id_produk dari $produk yang diterima melalui permintaan
$produkIdsRequested = collect($produk)->pluck('id')->toArray();

// Mencari id_produk yang berbeda antara produk pada detail invoice dan produk yang diterima melalui permintaan
$differentProdukIds = array_diff($produkIdsInDetailInv, $produk);

// Jika Anda ingin mendapatkan informasi lebih lanjut tentang produk yang berbeda, Anda dapat melakukan sesuatu seperti ini:
$differentProduk = Produk::whereIn('id', $differentProdukIds)->get();

// Sekarang Anda dapat melakukan apa pun yang Anda inginkan dengan $differentProduk


if (!empty($differentProdukIds)) {
    foreach ($detailinv as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
        
            $detail->delete();
        }
    }
    foreach ($detailso as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
            $detail->keterangan ="Cancelled";
            $detail->save();
        }
    }
    foreach ($detailrfo as $detail) {
        if (in_array($detail->product_id, $differentProdukIds)) {
            $detail->keterangan ="Cancelled";
            $detail->save();
        }
    }


}

}


$request->session()->flash('success', "Invoice berhasil diubah.");

return redirect()->route('superadmin.invoice.index');
     }
    public function admininvoiceindex(){

        $invoice = Inovice::orderBy('created_at', 'desc')->get();
    
        $so = SalesOrder::where('status_so','Terbit PO')->orderBy('created_at', 'desc')->count();

        $quote = Quotation::where('status_quote','Proses PO')->orderBy('created_at', 'desc')->count();

        $total = $so + $quote;
        return view ('admininvoice.invoice.index',[
            'invoice' => $invoice,
            'total' => $total,
        ]);
    }

    public function superadminindex(){

        $invoice = Inovice::orderBy('created_at', 'desc')->get();
    
        $so = SalesOrder::where('status_so','Terbit PO')->orderBy('created_at', 'desc')->count();

        $quote = Quotation::where('status_quote','Proses PO')->orderBy('created_at', 'desc')->count();

        $total = $so + $quote;
        return view ('superadmin.invoice.index',[
            'invoice' => $invoice,
            'total' => $total,
        ]);
    }

    public function download(Request $request, $id)
    {
        // Mengambil sales order dari database berdasarkan ID
        $invoice = Inovice::findOrFail($id);
    
        // Menandai bahwa sales order telah diunduh
        $invoice->is_download = true;

       
    
        // Menyimpan sales order tanpa mempengaruhi updated_at
        $invoice->save(['timestamps' => false]);
    
        // Mengembalikan respons sebagai JSON jika diperlukan
        return response()->json(['message' => 'Invoice has been downloaded successfully']);
    }

    public function downloaddo(Request $request, $id)
    {
        // Mengambil sales order dari database berdasarkan ID
        $invoice = Inovice::findOrFail($id);
    
        // Menandai bahwa sales order telah diunduh
        $invoice->is_download_do = true;

       
    
        // Menyimpan sales order tanpa mempengaruhi updated_at
        $invoice->save(['timestamps' => false]);
    
        // Mengembalikan respons sebagai JSON jika diperlukan
        return response()->json(['message' => 'Invoice has been downloaded successfully']);
    }
    
     public function index()
    {
        //
    }
    public function cancelinvoice(Request $request){
        $invoice = Inovice::orderBy('created_at', 'desc')->get();
        

        $invid = $request->invoice_id;
        $loggedInUser = auth()->user();
        $invoicedata = Inovice::find($request->invoice_id);


        if ($invoicedata) {
            $invoicedata->status_invoice = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $invoicedata->save();
        }



        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        
        $cancelreq = new CancelApprovalSA;
        $cancelreq -> invoice_id = $request->invoice_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> report_to = $report;
    
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('admininvoice.invoice.index',[
            'invoice' => $invoice,
        ]));

     }

     public function closinginvoice(Request $request)
     {
        $invoice = Inovice::orderBy('created_at', 'desc')->get();
        $invid = $request->invoice_id;

        $datainv = Inovice::find($invid);

        $datainv -> is_closing = "Yes";
        $datainv -> status_invoice ="Closing";
        $datainv -> save();
        $request->session()->flash('success', "Invoice berhasil closing");
        return redirect(route('admininvoice.invoice.index',[
            'invoice' => $invoice,
        ]));

     }
     public function superadminclosinginvoice(Request $request)
     {
       
        $invoice = Inovice::orderBy('created_at', 'desc')->get();
        $invid = $request->invoice_id;

        $datainv = Inovice::find($invid);

        $datainv -> is_closing = "Yes";
        $datainv -> status_invoice ="Closing";
        $datainv -> save();
        $request->session()->flash('success', "Invoice berhasil closing");
        return redirect(route('superadmin.invoice.index',[
            'invoice' => $invoice,
        ]));

     }
     public function superadmincancelinvoice(Request $request){
        $invoice = Inovice::orderBy('created_at', 'desc')->get();
        $invid = $request->invoice_id;

        $datainvoice = Inovice::find($invid);
        
        $quoteid = $datainvoice->quote_id;
        $soid = $datainvoice -> so_id;

    

        $datainvoice->status_invoice = "Cancelled";
       $datainvoice -> save();

        if($quoteid){
        $dataQuote = Quotation::where('id', $quoteid)->get();

        foreach($dataQuote as $item){
          
            $item -> status_quote ="Cancelled";
            $item->save();
        }
        }

        if($soid){
            $dataSO = SalesOrder::where('id', $soid)->get();

            foreach($dataSO as $item){
                $item -> status_so ="Cancelled";
                $item->save();
            }
        }

        $request->session()->flash('success', "Invoice berhasil dibatalkan");
        return redirect(route('superadmin.invoice.index',[
            'invoice' => $invoice,
        ]));
     }
    /**
     * Show the form for creating a new resource.
     */
    public function tampilpesananinvoice($id)
    {
    
       $pesanan = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();
       $invoice = Inovice::find($id);
       $noInvoice = $invoice->invoice_no;
      
       return view('admininvoice.invoice.tampilpesanan',[
           'pesanan' =>$pesanan,
           'noInvoice' => $noInvoice,
       ]);

    }

    public function superadmintampilpesananinvoice($id)
    {
    
       $pesanan = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();
       $invoice = Inovice::find($id);
       $noInvoice = $invoice->invoice_no;
      
       return view('superadmin.invoice.tampilpesanan',[
           'pesanan' =>$pesanan,
           'noInvoice' => $noInvoice,
       ]);

    }

     public function admininvoicecreate($id)
     {

        $data = SalesOrder::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $so = DetailSO::with('salesorder')->where('so_id', $id)->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastInvoice = Inovice::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $currentYear = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $currentMonth = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        
        $lastYear = $lastInvoice ? substr($lastInvoice->invoice_no, 12, 2) : null; // Mendapatkan dua digit tahun dari nomor invoice terakhir
        $lastMonth = $lastInvoice ? substr($lastInvoice->invoice_no, 9, 2) : null; // Mendapatkan dua digit bulan dari nomor invoice terakhir
        

        if ($currentYear != $lastYear || $currentMonth != $lastMonth) {
            // Jika bulan atau tahun saat ini berbeda dengan bulan atau tahun dari nomor invoice terakhir,
            // maka nomor urutan direset menjadi 1
            $newOrder = 1;
        } else {
            // Jika bulan dan tahun saat ini sama dengan bulan dan tahun dari nomor invoice terakhir,
            // maka nomor urutan diincrement
            $newOrder = $lastInvoice ? intval(substr($lastInvoice->invoice_no, 4, 4)) + 1 : 1;
        }
        
        $invoicenumber = 'INV/' . str_pad($newOrder, 4, '0', STR_PAD_LEFT) . '/' . $currentMonth . '/' . $currentYear; // Menggabungkan nomor invoice dengan tahun dan bulan
        
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

     public function superadmincreate($id)
     {

        $data = SalesOrder::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $so = DetailSO::with('salesorder')->where('so_id', $id)->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastInvoice = Inovice::latest()->first(); // Mendapatkan data invoice terakhir dari database

        $currentYear = now()->format('y'); // Mendapatkan dua digit tahun saat ini
        $currentMonth = now()->format('m'); // Mendapatkan dua digit bulan saat ini
        
        $lastYear = $lastInvoice ? substr($lastInvoice->invoice_no, 12, 2) : null; // Mendapatkan dua digit tahun dari nomor invoice terakhir
        $lastMonth = $lastInvoice ? substr($lastInvoice->invoice_no, 9, 2) : null; // Mendapatkan dua digit bulan dari nomor invoice terakhir
        

        if ($currentYear != $lastYear || $currentMonth != $lastMonth) {
            // Jika bulan atau tahun saat ini berbeda dengan bulan atau tahun dari nomor invoice terakhir,
            // maka nomor urutan direset menjadi 1
            $newOrder = 1;
        } else {
            // Jika bulan dan tahun saat ini sama dengan bulan dan tahun dari nomor invoice terakhir,
            // maka nomor urutan diincrement
            $newOrder = $lastInvoice ? intval(substr($lastInvoice->invoice_no, 4, 4)) + 1 : 1;
        }
        
        $invoicenumber = 'INV/' . str_pad($newOrder, 4, '0', STR_PAD_LEFT) . '/' . $currentMonth . '/' . $currentYear; // Menggabungkan nomor invoice dengan tahun dan bulan

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
 
  
        
        return view('superadmin.invoice.create',[
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

     public function admininvoiceperubahan($id){

        $data = Inovice::find($id);
        $detail = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();
    
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();
      
        return view('admininvoice.invoice.perubahaninvoice',[
            'data' => $data,
            'detail' => $detail,
            'customer' => $customer,
            'produk' => $produk,
        ]);
     }

     public function superadminperubahan($id){

        $data = Inovice::find($id);
        $detail = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();
    
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

     
      
        return view('superadmin.invoice.perubahaninvoice',[
            'data' => $data,
            'detail' => $detail,
            'customer' => $customer,
            'produk' => $produk,
        ]);
     }
     public function admininvoicecreatequote($id)
     {

        $data = Quotation::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $so = DetailQuotation::with('quotation')->where('quote_id', $id)->get();
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
 
  
        return view('admininvoice.invoice.createquote',[
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

     public function superadmincreatequote($id)
     {

        $data = Quotation::find($id);
        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $so = DetailQuotation::with('quotation')->where('quote_id', $id)->get();
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
 
  
        
        return view('superadmin.invoice.createquote',[
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

    $subtotal = 0;

    // Iterasi melalui setiap detail invoice
    $discountasli = $invoice->discount;
        $tipe = $invoice->is_persen;

      
        
    $subtotal = 0;
    foreach ($detailinvoice as $detail) {
        $subtotal += $detail->total_price;
    }

    if ($tipe == 'persen') {
        $discount =  ($discountasli / 100) * $subtotal;
    } elseif ($tipe == 'amount'){
        $discount = $invoice->discount;
    }

    $subtotalafterdiscount = $subtotal - $discount;



  $ppnpersen = $invoice -> ppn;
  
  $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;


    $pembayaran = $invoice->pembayaran;

    $total = $subtotalafterdiscount + $ppn;
    

    $sisatagihan = $total - $pembayaran;
    

    return view('admininvoice.invoice.tampilinvoice',[
        'invoice' => $invoice,
        'detailinvoice' => $detailinvoice,
        'subtotal' => $subtotal,
        'total' => $total,
        'ppn' => $ppn,
        'discount' => $discount,
        'sisatagihan' => $sisatagihan,
    ]);
}
public function superadmintampilinvoice($id){
    $invoice = Inovice::find($id);
    $detailinvoice = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();

    $subtotal = 0;

    // Iterasi melalui setiap detail invoice
    $discountasli = $invoice->discount;
        $tipe = $invoice->is_persen;

      
        
    $subtotal = 0;
    foreach ($detailinvoice as $detail) {
        $subtotal += $detail->total_price;
    }

    if ($tipe == 'persen') {
        $discount =  ($discountasli / 100) * $subtotal;
    } elseif ($tipe == 'amount'){
        $discount = $invoice->discount;
    }

    $subtotalafterdiscount = $subtotal - $discount;



  $ppnpersen = $invoice -> ppn;
  
  $ppn = ($ppnpersen / 100) * $subtotalafterdiscount;


    $pembayaran = $invoice->pembayaran;

    $total = $subtotalafterdiscount + $ppn;
    

    $sisatagihan = $total - $pembayaran;
 


    return view('superadmin.invoice.tampilinvoice',[
        'invoice' => $invoice,
        'detailinvoice' => $detailinvoice,
        'subtotal' => $subtotal,
        'total' => $total,
        'ppn' => $ppn,
        'discount' => $discount,
        'sisatagihan' => $sisatagihan,
    ]);
}


     public function admininvoicestore(Request $request)
     {
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
     
        $custid = $request -> cust_id;

        $customer = Customer::find($custid);

        $namacust = $customer->nama_customer;

        $so = SalesOrder::find($request->so_id);

        $soid = $so->id;
        $so->status_so = "Terbit Invoice";
        $so->save();
    
        // 2. Dari so_id, ambil rfo_id dan update status_rfo menjadi "Terbit Invoice"
        $rfo_id = $so->rfo_id;
        $rfo = RFO::find($rfo_id);
        $rfo->status_rfo = "Terbit Invoice";
        $rfo->save();

       $detailsopo = DetailSoPo::where('so_id', $soid)->get();

       foreach($detailsopo as $detail){
            $id = $detail->po_id;

            $datapo = PurchaseOrder::find($id);
            $datapo -> is_cancel ="No";
            $datapo ->save();
       }

        $invoice = new Inovice;

        $noinvoice = $request -> invoice_no;

       
        $existingdata = Inovice::where('invoice_no', $noinvoice)->first();
     

        if($existingdata !== null && $existingdata) {
            $request->session()->flash('error', "Data gagal disimpan, Invoice sudah ada");
            return redirect()->route('admininvoice.invoice.index');
        }

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
        $invoice -> created_by = $loggedInUsername;

       
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

     public function superadminstore(Request $request)
     {
    
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
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

        $soid = $so->id;
        $detailsopo = DetailSoPo::where('so_id', $soid)->get();

       foreach($detailsopo as $detail){
            $id = $detail->po_id;

            $datapo = PurchaseOrder::find($id);
            $datapo -> is_cancel ="No";
            $datapo ->save();
       }

        $invoice = new Inovice;

        $noinvoice = $request -> invoice_no;

        $existingdata = Inovice::where('invoice_no', $noinvoice)->first();

        if($existingdata !== null && $existingdata) {
            $request->session()->flash('error', "Data gagal disimpan, Invoice sudah ada");
            return redirect()->route('superadmin.invoice.index');
        }
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
        $invoice -> created_by = $loggedInUsername;

       
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

        return redirect()->route('superadmin.invoice.index');
     }

     public function admininvoicestorequote(Request $request)
     {
    
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $custid = $request -> cust_id;

        $customer = Customer::find($custid);

        $namacust = $customer->nama_customer;

        $quote = Quotation::find($request->quote_id);
        $quote->status_quote = "Terbit Invoice";
        $quote->save();
    
        
        $quoteid = $quote->id;
        $detailsopo = DetailSoPo::where('quote_id', $quoteid)->get();

       foreach($detailsopo as $detail){
            $id = $detail->po_id;

            $datapo = PurchaseOrder::find($id);
            $datapo -> is_cancel ="No";
            $datapo ->save();
       }

        $invoice = new Inovice;
        $invoice->quote_id = $request->quote_id;
        $invoice->invoice_no = $request -> invoice_no;
        $invoice->invoice_date = $request -> invoice_date;
        $invoice -> cust_id = $request -> cust_id;
        $invoice -> nama_customer = $namacust;
        $invoice -> no_quote = $quote->no_quote;
        $invoice -> alamat = $request -> alamat;
        $invoice -> subtotal = $request -> subtotal;
        $invoice -> is_persen = $request->is_persen;
        $invoice -> discount = $request -> discount;
        $invoice -> ppn = $request -> ppn;
        $invoice -> total = $request->total;
$invoice -> created_by = $loggedInUsername;
       
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

     public function superadminstorequote(Request $request)
     {
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
     
        $custid = $request -> cust_id;

        $customer = Customer::find($custid);

        $namacust = $customer->nama_customer;

        $quote = Quotation::find($request->quote_id);
        $quote->status_quote = "Terbit Invoice";
        $quote->save();
    
    

        $invoice = new Inovice;
        $invoice->quote_id = $request->quote_id;
        $invoice->invoice_no = $request -> invoice_no;
        $invoice->invoice_date = $request -> invoice_date;
        $invoice -> cust_id = $request -> cust_id;
        $invoice -> nama_customer = $namacust;
        $invoice -> no_quote = $quote->no_quote;
        $invoice -> alamat = $request -> alamat;
        $invoice -> subtotal = $request -> subtotal;
        $invoice -> is_persen = $request->is_persen;
        $invoice -> discount = $request -> discount;
        $invoice -> ppn = $request -> ppn;
        $invoice -> total = $request->total;
        $invoice -> created_by = $loggedInUsername;

        $quoteid = $quote->id;
        $detailsopo = DetailSoPo::where('quote_id', $quoteid)->get();

       foreach($detailsopo as $detail){
            $id = $detail->po_id;

            $datapo = PurchaseOrder::find($id);
            $datapo -> is_cancel ="No";
            $datapo ->save();
       }

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

        return redirect()->route('superadmin.invoice.index');
     }
     public function showso()
     {
        $so = SalesOrder::where('status_so','Terbit PO')->orderBy('created_at', 'desc')->get();

        $quote = Quotation::where('status_quote','Proses PO')->orderBy('created_at', 'desc')->get();


        return view('admininvoice.invoice.showso',[
            'so' => $so,
            'quote' => $quote,
        ]);
     }

     public function superadminshowso()
     {
        $so = SalesOrder::where('status_so','Terbit PO')->orderBy('created_at', 'desc')->get();

        $quote = Quotation::where('status_quote','Proses PO')->orderBy('created_at', 'desc')->get();


        return view('superadmin.invoice.showso',[
            'so' => $so,
            'quote' => $quote,
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
