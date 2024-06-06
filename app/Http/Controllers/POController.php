<?php

namespace App\Http\Controllers;

use App\Models\CancelApprovalSA;
use App\Models\Channel;
use App\Models\DetailPO;
use App\Models\DetailQuotation;
use App\Models\DetailSO;
use App\Models\DetailSoPo;
use App\Models\Produk;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RFO;
use App\Models\SalesOrder;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class POController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function managerindex()
     {    
        
        $po = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->count();
        $quote = Quotation::where('status_quote','Quotation Dibuat')->orderBy('created_at', 'desc')->count();

        $total = $so + $quote;

        return view ('manager.po.index',[
            'po' => $po,
            'total' => $total,
        ]);

     }


     public function managertampilpesananpo($id)
     {
     
        $pesanan = DetailPO::with('purchaseorder')->where('po_id', $id)->get();
        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;
       
        return view('manager.po.tampilpesanan',[
            'pesanan' =>$pesanan,
            'noPo' => $noPo,
        ]);
 
     }


     public function managertampilsoquote($id){
        $detail = DetailSoPo::with('purchaseorder')->where('po_id', $id)->get();

        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;

        return view ('manager.po.tampilsoquote',[
            'detail' => $detail,
            'noPo' => $noPo,
        ]);
     }


     public function managertampilpo($id){
        $po = PurchaseOrder::find($id);
        $detailpo = DetailPO::with('purchaseorder')->where('po_id', $id)->get();

        $subtotal = 0;
    foreach ($detailpo as $detail) {
        $subtotal += $detail->total_price;
    }

    $totalqty = 0;
    foreach ($detailpo as $detail) {
        $totalqty += $detail->qty;
    }


        return view ('manager.po.tampilpo',[
            'po' => $po, 
            'detailpo' => $detailpo,
            'subtotal' => $subtotal,
            'totalqty' => $totalqty,
        ]);

     }




public function showchannel()
{

    $channel = Channel::get();
 
    return view ('admininvoice.po.showchannel',[
        'channel' => $channel,
    ]);

}

public function showsupplier(){

    
    $supplier = Supplier::get();

    return view('admininvoice.po.showsupplier',[
       
        'supplier' => $supplier,
    ]);

}
public function superadminshowsupplier(){

    
    $supplier = Supplier::get();

    return view('superadmin.po.showsupplier',[
       
        'supplier' => $supplier,
    ]);

}

public function createPO(Request $request){

    $datasupplier = Supplier::all();
    $datachannel = Channel::all();

    


 
    $polast = PurchaseOrder::latest()->first();

    // $kodesupplier = $polast->kode_supplier;

    // $supplier = Supplier::find($supid);

    // $kodesupplier = $supplier->kode_supplier;
  
    

   

    // $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodesupplier)->latest()->first();
    // $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
    // $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
   
    // $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

    

    // // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
    // if ($lastpo) {
    //     $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
    //     $lastMonth = $lastpo->month; // Mendapatkan bulan dari nomor PO terakhir
    //     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");// Mendapatkan indeks bulan romawi dari nomor PO terakhir

    //     $lastMonthIndex= $romanMonth[$lastMonth];
        
    // } else {
    //     $lastYear = '0000';
    //     $lastMonthIndex = false;
    // }
    // if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonth) {
    //     // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
    //     // maka nomor urutan direset menjadi 1
    //     $ponumber = '0001/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    // } else {
    //     // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
    //     // maka nomor urutan diincrement
    //     $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
    //     $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    // }

   
    $produk = Produk::all();

    return view ('admininvoice.po.createpochannel',[
        // 'ponumber' => $ponumber,
        'produk' => $produk,
       
        // 'kodechannel' => $kodechannel,
        'datachannel' => $datachannel,
        'datasupplier' => $datasupplier,
     

    ]);

}

public function simpanpochannel(Request $request){


    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
   
    $channelid = $request->channel_id;
    $supplierid = $request->supplier_id;

   

    $datachannel = Channel::find($channelid);
  
    $datasupplier = Supplier::find($supplierid);
   
    $loggedInUser = auth()->user();

    $tanggalHariIni = Carbon::now();
    $month = $tanggalHariIni->month;
    
    $namauser = $loggedInUser->nama;
    $nohp = $loggedInUser->no_hp;
    $email = $loggedInUser-> email;
    $userid = $loggedInUser->id;

   

    

    $kodesupplier = $datasupplier->kode_supplier;
    $kodechannel = $datachannel -> kode_channel;
    

   

    $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodesupplier)->latest()->first();
    
  
    $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
    $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
   
    $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

    

    // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
    if ($lastpo) {
        $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
        $lastMonth = $lastpo->month; // Mendapatkan bulan dari nomor PO terakhir
        $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");// Mendapatkan indeks bulan romawi dari nomor PO terakhir

        $lastMonthIndex= $romanMonth[$lastMonth];
        
    } else {
        $lastYear = '0000';
        $lastMonthIndex = false;
    }


    if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonth) {
        // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
        // maka nomor urutan direset menjadi 1
       
        $ponumber = '0001/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    } else {
        // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
        // maka nomor urutan diincrement
        
        $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
       
        $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    }


    $po = new PurchaseOrder;


     
           
            $existingdata = PurchaseOrder::where('no_po', $ponumber)->first();

            if($existingdata !== null && $existingdata) {
                $request->session()->flash('error', "Data gagal disimpan, PO sudah ada");
                return redirect()->route('admininvoice.po.index');
            }

    $po->no_po = $ponumber;
    $po->po_date = $request->po_date;
    $po->user_id = $userid;
    $po->nama_user = $namauser;
    $po->email = $email;
    $po->no_hp = $nohp;
    $po -> month = $month;
    $po->kode_channel = $kodechannel;
    $po->kode_supplier = $kodesupplier;
    $po->created_by = $loggedInUsername;
   
    $po->save();

$poDetails = [];


if ($request->has('product') && $request->has('quantity') && $request->has('price')) {
foreach ($request->product as $index => $productId) {
    $product = Produk::find($productId); // Mendapatkan data produk dari basis data

    $qty = $request->quantity[$index];
    $harga = $product -> harga_beli;
    $totalprice = $qty * $harga;

    $discount = $request->discount[$index];

    $totalprice = $qty * $harga;
    $amount = ($discount/100) * $totalprice;

    $totalpriceafter = $totalprice - $amount;

    if ($product) {
        $poDetails[] = [
            'po_id' => $po->id,
            'product_id' => $productId,
            'qty' => $request->quantity[$index],
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
            'amount' => $amount,
            'discount' => $discount,
            'total_price_after_discount' => $totalpriceafter,
        ];
    }
    
}

DetailPO::insert($poDetails); 

$request->session()->flash('success', "Purchase order berhasil dibuat.");

return redirect()->route('admininvoice.po.index');
}
}


public function superadmincreatePO(){

    $datasupplier = Supplier::all();
    $datachannel = Channel::all();

    


 
    $polast = PurchaseOrder::latest()->first();

    // $kodesupplier = $polast->kode_supplier;

    // $supplier = Supplier::find($supid);

    // $kodesupplier = $supplier->kode_supplier;
  
    

   

    // $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodesupplier)->latest()->first();
    // $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
    // $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
   
    // $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

    

    // // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
    // if ($lastpo) {
    //     $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
    //     $lastMonth = $lastpo->month; // Mendapatkan bulan dari nomor PO terakhir
    //     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");// Mendapatkan indeks bulan romawi dari nomor PO terakhir

    //     $lastMonthIndex= $romanMonth[$lastMonth];
        
    // } else {
    //     $lastYear = '0000';
    //     $lastMonthIndex = false;
    // }
    // if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonth) {
    //     // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
    //     // maka nomor urutan direset menjadi 1
    //     $ponumber = '0001/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    // } else {
    //     // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
    //     // maka nomor urutan diincrement
    //     $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
    //     $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    // }

   
    $produk = Produk::all();

    return view ('superadmin.po.createpochannel',[
        // 'ponumber' => $ponumber,
        'produk' => $produk,
       
        // 'kodechannel' => $kodechannel,
        'datachannel' => $datachannel,
        'datasupplier' => $datasupplier,
     

    ]);

}

public function superadminsimpanpochannel(Request $request){
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 

    $channelid = $request->channel_id;
    $supplierid = $request->supplier_id;

   

    $datachannel = Channel::find($channelid);
  
    $datasupplier = Supplier::find($supplierid);
   
    $loggedInUser = auth()->user();

    $tanggalHariIni = Carbon::now();
    $month = $tanggalHariIni->month;
    
    $namauser = $loggedInUser->nama;
    $nohp = $loggedInUser->no_hp;
    $email = $loggedInUser-> email;
    $userid = $loggedInUser->id;

   

    

    $kodesupplier = $datasupplier->kode_supplier;
    $kodechannel = $datachannel -> kode_channel;
    

   

    $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodesupplier)->latest()->first();
    
  
    $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
    $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
   
    $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

    

    // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
    if ($lastpo) {
        $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
        $lastMonth = $lastpo->month; // Mendapatkan bulan dari nomor PO terakhir
        $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");// Mendapatkan indeks bulan romawi dari nomor PO terakhir

        $lastMonthIndex= $romanMonth[$lastMonth];
        
    } else {
        $lastYear = '0000';
        $lastMonthIndex = false;
    }


    if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonth) {
        // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
        // maka nomor urutan direset menjadi 1
       
        $ponumber = '0001/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    } else {
        // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
        // maka nomor urutan diincrement
        
        $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
       
        $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO-E'.$kodechannel.'/BPM-' . $kodesupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
    }


    $po = new PurchaseOrder;

    $existingdata = PurchaseOrder::where('no_po', $ponumber)->first();

    if($existingdata !== null && $existingdata) {
        $request->session()->flash('error', "Data gagal disimpan, PO sudah ada");
        return redirect()->route('superadmin.po.index');
    }
    $po->no_po = $ponumber;
    $po->po_date = $request->po_date;
    $po->user_id = $userid;
    $po->nama_user = $namauser;
    $po->email = $email;
    $po->no_hp = $nohp;
    $po -> month = $month;
    $po->kode_channel = $kodechannel;
    $po->kode_supplier = $kodesupplier;
   $po->created_by = $loggedInUsername;
    $po->save();

$poDetails = [];


if ($request->has('product') && $request->has('quantity') && $request->has('price')) {
foreach ($request->product as $index => $productId) {
    $product = Produk::find($productId); // Mendapatkan data produk dari basis data

    $qty = $request->quantity[$index];
    $harga = $product -> harga_beli;
    $discount = $request->discount[$index];

    $totalprice = $qty * $harga;
    $amount = ($discount/100) * $totalprice;

    $totalpriceafter = $totalprice - $amount;

    if ($product) {
        $poDetails[] = [
            'po_id' => $po->id,
            'product_id' => $productId,
            'qty' => $request->quantity[$index],
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
            'amount' => $amount,
            'discount' => $discount,
            'total_price_after_discount' => $totalpriceafter,
        ];
    }
    
}

DetailPO::insert($poDetails); 

$request->session()->flash('success', "Purchase order berhasil dibuat.");

return redirect()->route('superadmin.po.index');
}
}
     public function admininvoiceindex()
     {
        $po = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->count();
        $quote = Quotation::where('status_quote','Quotation Dibuat')->orderBy('created_at', 'desc')->count();

        $total = $so + $quote;
        return view ('admininvoice.po.index',[
            'po' => $po,
            'total' => $total,
        ]);
     }

     public function superadminindex()
     {    
        
        $po = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->count();
        $quote = Quotation::where('status_quote','Quotation Dibuat')->orderBy('created_at', 'desc')->count();

        $total = $so + $quote;

        return view ('superadmin.po.index',[
            'po' => $po,
            'total' => $total,
        ]);

     }

     public function superadmincreate(Request $request)
     {
         $selectedQuotes = $request->input('selected_po');
         $selectedSOs = $request->input('selected_so');
     
         $allDates = []; // Array to collect all dates
     
         if ($selectedSOs) {
             $soDetail = [];
     
             foreach ($selectedSOs as $selectedSO) {
                 $details = DetailSO::where('so_id', $selectedSO)->get();
                 $so = SalesOrder::find($selectedSO); 
                 $tanggalSO = $so->so_date; 
                 $allDates[] = $tanggalSO; // Add the date to the array
     
                 foreach ($details as $detail) {
                     $kodeSupplier = $detail->kode_supplier;
                     $kodechannel = $detail->kode_channel;
     
                     $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodeSupplier)->latest()->first();
                     $currentYear = now()->format('Y');
                     $currentMonth = ltrim(now()->format('m'), '0');
                     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
     
                     if ($lastpo) {
                         $lastYear = substr($lastpo->no_po, -4);
                         $lastMonth = substr($lastpo->no_po, 16, -5);
                         $lastMonthIndex = array_search($lastMonth, $romanMonth);
                     } else {
                         $lastYear = '0000';
                         $lastMonthIndex = false;
                     }
     
                     if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                         $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     } else {
                         $lastOrder = intval(substr($lastpo->no_po, 0, 4));
                         $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     }
     
                     if (!isset($soDetail[$kodeSupplier])) {
                         $soDetail[$kodeSupplier] = [
                             'po_number' => $ponumber,
                             'tanggal' => $tanggalSO, 
                             'items' => []
                         ];
                     }
     
                     $index = array_search($detail->product_id, array_column($soDetail[$kodeSupplier]['items'], 'produk_id'));
     
                     if ($index !== false) {
                         $soDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
                     } else {
                         $soDetail[$kodeSupplier]['items'][] = [
                             'produk_id' => $detail->product_id,
                             'nama_produk' => $detail->nama_produk,
                             'kode_produk' => $detail->kode_produk,
                             'harga_beli' => $detail->produk->harga_beli,
                             'quantity' => $detail->qty,
                             'no_po' => $ponumber
                         ];
                     }
                 }
             }
         }
     
         if ($selectedQuotes) {
             $quoteDetail = [];
     
             foreach ($selectedQuotes as $selectedQuote) {
                 $details = DetailQuotation::where('quote_id', $selectedQuote)->get();
                 $quote = Quotation::find($selectedQuote); 
                 $tanggalQuote = $quote->quote_date; 
                 $allDates[] = $tanggalQuote; // Add the date to the array
     
                 foreach ($details as $detail) {
                     $kodeSupplier = $detail->kode_supplier;
                     $lastpo = PurchaseOrder::where('kode_supplier', $kodeSupplier)->latest()->first();
                     $currentYear = now()->format('Y');
                     $currentMonth = ltrim(now()->format('m'), '0');
                     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
     
                     if ($lastpo) {
                         $lastYear = substr($lastpo->no_po, -4);
                         $lastMonth = substr($lastpo->no_po, 16, -5);
                         $lastMonthIndex = array_search($lastMonth, $romanMonth);
                     } else {
                         $lastYear = '0000';
                         $lastMonthIndex = false;
                     }
     
                     if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                         $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     } else {
                         $lastOrder = intval(substr($lastpo->no_po, 0, 4));
                         $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     }
     
                     if (!isset($quoteDetail[$kodeSupplier])) {
                         $quoteDetail[$kodeSupplier] = [
                             'po_number' => $ponumber,
                             'tanggal' => $tanggalQuote, 
                             'items' => []
                         ];
                     }
     
                     $index = array_search($detail->product_id, array_column($quoteDetail[$kodeSupplier]['items'], 'produk_id'));
     
                     if ($index !== false) {
                         $quoteDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
                     } else {
                         $quoteDetail[$kodeSupplier]['items'][] = [
                             'produk_id' => $detail->product_id,
                             'nama_produk' => $detail->nama_produk,
                             'kode_produk' => $detail->kode_produk,
                             'harga_beli' => $detail->produk->harga_beli,
                             'quantity' => $detail->qty,
                             'no_po' => $ponumber
                         ];
                     }
                 }
             }
         }
     
         if ($selectedSOs && !$selectedQuotes) {
             $mergedDetail = $soDetail;
         }
     
         if (!$selectedSOs && $selectedQuotes) {
             $mergedDetail = $quoteDetail;
         }
     
         if ($selectedSOs && $selectedQuotes) {
             $mergedDetail = [];
     
             foreach ($soDetail as $kodeSupplier => $details) {
                 if (isset($mergedDetail[$kodeSupplier])) {
                     $mergedDetail[$kodeSupplier] = array_merge($mergedDetail[$kodeSupplier], $details);
                 } else {
                     $mergedDetail[$kodeSupplier] = $details;
                 }
     
                 if (isset($quoteDetail[$kodeSupplier])) {
                     foreach ($quoteDetail[$kodeSupplier]['items'] as $quoteDetailItem) {
                         $index = array_search($quoteDetailItem['produk_id'], array_column($mergedDetail[$kodeSupplier]['items'], 'produk_id'));
     
                         if ($index !== false) {
                             $mergedDetail[$kodeSupplier]['items'][$index]['quantity'] += $quoteDetailItem['quantity'];
                         } else {
                             $mergedDetail[$kodeSupplier]['items'][] = $quoteDetailItem;
                         }
                     }
                 }
             }
     
             foreach ($quoteDetail as $kodeSupplier => $quoteDetails) {
                 if (!isset($soDetail[$kodeSupplier])) {
                     $mergedDetail[$kodeSupplier] = $quoteDetails;
                 }
             }
         }
        
         // Get the oldest date from the collected dates
         $oldestDate = min($allDates);
      
     
         $produk = Produk::orderBy('nama_produk', 'asc')->get();
     
         return view('superadmin.po.create', [
             'produk' => $produk,
             'selectedSOs' => $selectedSOs,
             'selectedQuotes' => $selectedQuotes,
             'mergedDetail' => $mergedDetail,
             'oldestdate' => $oldestDate, // Pass the oldest date to the view
         ]);
     }

     public function admininvoicecreate(Request $request)
     {
         $selectedQuotes = $request->input('selected_po');
         $selectedSOs = $request->input('selected_so');
     
         $allDates = []; // Array to collect all dates
     
         if ($selectedSOs) {
             $soDetail = [];
     
             foreach ($selectedSOs as $selectedSO) {
                 $details = DetailSO::where('so_id', $selectedSO)->get();
                 $so = SalesOrder::find($selectedSO); 
                 $tanggalSO = $so->so_date; 
                 $allDates[] = $tanggalSO; // Add the date to the array
     
                 foreach ($details as $detail) {
                     $kodeSupplier = $detail->kode_supplier;
                     $kodechannel = $detail->kode_channel;
     
                     $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodeSupplier)->latest()->first();
                     $currentYear = now()->format('Y');
                     $currentMonth = ltrim(now()->format('m'), '0');
                     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
     
                     if ($lastpo) {
                         $lastYear = substr($lastpo->no_po, -4);
                         $lastMonth = substr($lastpo->no_po, 16, -5);
                         $lastMonthIndex = array_search($lastMonth, $romanMonth);
                     } else {
                         $lastYear = '0000';
                         $lastMonthIndex = false;
                     }
     
                     if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                         $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     } else {
                         $lastOrder = intval(substr($lastpo->no_po, 0, 4));
                         $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     }
     
                     if (!isset($soDetail[$kodeSupplier])) {
                         $soDetail[$kodeSupplier] = [
                             'po_number' => $ponumber,
                             'tanggal' => $tanggalSO, 
                             'items' => []
                         ];
                     }
     
                     $index = array_search($detail->product_id, array_column($soDetail[$kodeSupplier]['items'], 'produk_id'));
     
                     if ($index !== false) {
                         $soDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
                     } else {
                         $soDetail[$kodeSupplier]['items'][] = [
                             'produk_id' => $detail->product_id,
                             'nama_produk' => $detail->nama_produk,
                             'kode_produk' => $detail->kode_produk,
                             'harga_beli' => $detail->produk->harga_beli,
                             'quantity' => $detail->qty,
                             'no_po' => $ponumber
                         ];
                     }
                 }
             }
         }
     
         if ($selectedQuotes) {
             $quoteDetail = [];
     
             foreach ($selectedQuotes as $selectedQuote) {
                 $details = DetailQuotation::where('quote_id', $selectedQuote)->get();
                 $quote = Quotation::find($selectedQuote); 
                 $tanggalQuote = $quote->quote_date; 
                 $allDates[] = $tanggalQuote; // Add the date to the array
     
                 foreach ($details as $detail) {
                     $kodeSupplier = $detail->kode_supplier;
                     $lastpo = PurchaseOrder::where('kode_supplier', $kodeSupplier)->latest()->first();
                     $currentYear = now()->format('Y');
                     $currentMonth = ltrim(now()->format('m'), '0');
                     $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
     
                     if ($lastpo) {
                         $lastYear = substr($lastpo->no_po, -4);
                         $lastMonth = substr($lastpo->no_po, 16, -5);
                         $lastMonthIndex = array_search($lastMonth, $romanMonth);
                     } else {
                         $lastYear = '0000';
                         $lastMonthIndex = false;
                     }
     
                     if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                         $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     } else {
                         $lastOrder = intval(substr($lastpo->no_po, 0, 4));
                         $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
                     }
     
                     if (!isset($quoteDetail[$kodeSupplier])) {
                         $quoteDetail[$kodeSupplier] = [
                             'po_number' => $ponumber,
                             'tanggal' => $tanggalQuote, 
                             'items' => []
                         ];
                     }
     
                     $index = array_search($detail->product_id, array_column($quoteDetail[$kodeSupplier]['items'], 'produk_id'));
     
                     if ($index !== false) {
                         $quoteDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
                     } else {
                         $quoteDetail[$kodeSupplier]['items'][] = [
                             'produk_id' => $detail->product_id,
                             'nama_produk' => $detail->nama_produk,
                             'kode_produk' => $detail->kode_produk,
                             'harga_beli' => $detail->produk->harga_beli,
                             'quantity' => $detail->qty,
                             'no_po' => $ponumber
                         ];
                     }
                 }
             }
         }
     
         if ($selectedSOs && !$selectedQuotes) {
             $mergedDetail = $soDetail;
         }
     
         if (!$selectedSOs && $selectedQuotes) {
             $mergedDetail = $quoteDetail;
         }
     
         if ($selectedSOs && $selectedQuotes) {
             $mergedDetail = [];
     
             foreach ($soDetail as $kodeSupplier => $details) {
                 if (isset($mergedDetail[$kodeSupplier])) {
                     $mergedDetail[$kodeSupplier] = array_merge($mergedDetail[$kodeSupplier], $details);
                 } else {
                     $mergedDetail[$kodeSupplier] = $details;
                 }
     
                 if (isset($quoteDetail[$kodeSupplier])) {
                     foreach ($quoteDetail[$kodeSupplier]['items'] as $quoteDetailItem) {
                         $index = array_search($quoteDetailItem['produk_id'], array_column($mergedDetail[$kodeSupplier]['items'], 'produk_id'));
     
                         if ($index !== false) {
                             $mergedDetail[$kodeSupplier]['items'][$index]['quantity'] += $quoteDetailItem['quantity'];
                         } else {
                             $mergedDetail[$kodeSupplier]['items'][] = $quoteDetailItem;
                         }
                     }
                 }
             }
     
             foreach ($quoteDetail as $kodeSupplier => $quoteDetails) {
                 if (!isset($soDetail[$kodeSupplier])) {
                     $mergedDetail[$kodeSupplier] = $quoteDetails;
                 }
             }
         }
        
         // Get the oldest date from the collected dates
         $oldestDate = min($allDates);
      
     
         $produk = Produk::orderBy('nama_produk', 'asc')->get();
     
         return view('admininvoice.po.create', [
             'produk' => $produk,
             'selectedSOs' => $selectedSOs,
             'selectedQuotes' => $selectedQuotes,
             'mergedDetail' => $mergedDetail,
             'oldestdate' => $oldestDate, // Pass the oldest date to the view
         ]);
     }
     
     public function tampilpesananpo($id)
     {
     
        $pesanan = DetailPO::with('purchaseorder')->where('po_id', $id)->get();
        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;
       
        return view('admininvoice.po.tampilpesanan',[
            'pesanan' =>$pesanan,
            'noPo' => $noPo,
        ]);
 
     }

     public function superadmintampilpesananpo($id)
     {
     
        $pesanan = DetailPO::with('purchaseorder')->where('po_id', $id)->get();
        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;
       
        return view('superadmin.po.tampilpesanan',[
            'pesanan' =>$pesanan,
            'noPo' => $noPo,
        ]);
 
     }

     public function tampilsoquote($id){
        $detail = DetailSoPo::with('purchaseorder')->where('po_id', $id)->get();

        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;

        return view ('admininvoice.po.tampilsoquote',[
            'detail' => $detail,
            'noPo' => $noPo,
        ]);
     }

     public function superadmintampilsoquote($id){
        $detail = DetailSoPo::with('purchaseorder')->where('po_id', $id)->get();

        $po = PurchaseOrder::find($id);
        $noPo = $po->no_po;

        return view ('superadmin.po.tampilsoquote',[
            'detail' => $detail,
            'noPo' => $noPo,
        ]);
     }
     public function admininvoicesimpan (Request $request){
        $data = $request->all();
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
       
        $poNumbers = $request->input('po_number');
        // Iterasi melalui setiap nomor PO
        $kodeSuppliers = $request->input('kode_supplier');  

        $poNumbers = $request->input('po_number');
        $poIds = $request->input('po_id');
        $kodeSuppliers = $request->input('kode_supplier');
        $produk = $request->input('produk');
        $prices = $request->input('price');
        $quantities = $request->input('qty');
        $discount = $request ->input('discount');
        
        $tanggalHariIni = Carbon::now();
$month =$tanggalHariIni->month;

        foreach ($kodeSuppliers as $kodeSupplier => $poData) {

          

            
            $soId = $request->input('selected_so');
        $soIds = json_decode($soId);

        $quoteId = $request->input('selected_quote');
        $quoteIds = json_decode($quoteId);
   
        $loggedInUser = auth()->user();
        $namauser = $loggedInUser->nama;
        $nohp = $loggedInUser->no_hp;
        $email = $loggedInUser-> email;
        $userid = $loggedInUser->id;
        
        $po = new PurchaseOrder;


        
        $ponumber = $poNumbers[$kodeSupplier][0]; 

        $existingdata = PurchaseOrder::where('no_po', $ponumber)->first();

        if($existingdata !== null && $existingdata) {
            $request->session()->flash('error', "Data gagal disimpan, PO sudah ada");
            return redirect()->route('admininvoice.po.index');
        }
        $po->no_po = $poNumbers[$kodeSupplier][0]; 
        $po->po_date = $request->po_date;
        $po->user_id = $userid;
        $po->nama_user = $namauser;
        $po->email = $email;
        $po->no_hp = $nohp;
        $po -> kode_supplier = $kodeSupplier;
        $po -> kode_channel = "BPM";
        $po -> month = $month;
        $po -> created_by = $loggedInUsername;
                
     $po -> save();
       $poId = $po->id;
       $datapo = PurchaseOrder::find($poId);

       $coba = $request->produk[$kodeSupplier];
    

       $poDetails = [];
foreach ($request->produk[$kodeSupplier] as $index => $productId) {

        
    $product = Produk::find($productId); // Mendapatkan data produk dari basis data

    $qty = $quantities[$kodeSupplier][$index];
    $harga = $prices[$kodeSupplier][$index];
    $totalprice = $qty * $harga;

    $diskon = $discount[$kodeSupplier][$index];

    $totalprice = $qty * $harga;

    $amount = ($diskon/100) * $totalprice;

    $totalafter = $totalprice - $amount;

    if ($product) {
        $poDetails[] = [
            'po_id' => $poId,
            'product_id' => $productId,
            'qty' => $qty,
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
            'discount' => $diskon,
            'amount' => $amount,
            'total_price_after_discount' => $totalafter,
           
        ];
    }
    
}

DetailPO::insert($poDetails); 
$soIds = $soIds ?? [];
$quoteIds = $quoteIds ?? [];

// Gabungkan kedua array jika keduanya memiliki nilai yang valid
$mergedIds = array_merge($soIds, $quoteIds);


foreach ($mergedIds as $id) {

            if (in_array($id, $soIds)) {
                // ID adalah dari jenis Sales Order
                $so = SalesOrder::find($id);
                $so->status_so = "Terbit PO";
                $so->save();
        
                DetailSoPo::create([
                  'po_id' => $poId,
                    'so_id' => $id,
                    'quote_id' => null,
                    'rfo_id' => $so->rfo_id,
                    'no_so' => $so->no_so,
                    'no_po' => $datapo->no_po,
                    'no_rfo' => $so->no_rfo,
                    'kode_supplier' => $so->kode_supplier,
                    
                ]);
        
                $rfo = RFO::find($so->rfo_id);
                $rfo->status_rfo = "Proses PO";
                $rfo->save();
            } elseif (in_array($id, $quoteIds)) {
                // ID adalah dari jenis Quote
                $quote = Quotation::find($id);
                // Lakukan apa pun yang diperlukan untuk mengelola Quote
                $quote->status_quote = "Proses PO";
                $quote->save();

                DetailSoPo::create([
                  'po_id' => $poId,
                    'so_id' => null,
                    'quote_id' => $id,
                    'rfo_id' => null,
                    'no_so' => null,
                    'no_po' => $datapo->no_po,
                    'no_rfo' => null,
                    'no_quote' => $quote -> no_quote,
                    'kode_supplier' => $quote->kode_supplier,
                ]);

              
                // Lakukan logika lain yang diperlukan untuk Quote
            }
        }
}


    
    // Setelah selesai iterasi foreach, lakukan penyimpanan detail pembelian untuk setiap nomor PO yang telah dikumpulkan
  

     
        

 
        


 
    $request->session()->flash('success', "Purchase order berhasil dibuat.");

    return redirect()->route('admininvoice.po.index');
  

     }
     
     public function superadminsimpan (Request $request){
       
        $data = $request->all();

        $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
        $poNumbers = $request->input('po_number');
        // Iterasi melalui setiap nomor PO
        $kodeSuppliers = $request->input('kode_supplier');  

        $poNumbers = $request->input('po_number');
        $poIds = $request->input('po_id');
        $kodeSuppliers = $request->input('kode_supplier');
        $produk = $request->input('produk');
        $prices = $request->input('price');
        $quantities = $request->input('qty');
        $discount = $request->input('discount');
     
        $tanggalHariIni = Carbon::now();
$month =$tanggalHariIni->month;

        foreach ($kodeSuppliers as $kodeSupplier => $poData) {

          

            
            $soId = $request->input('selected_so');
        $soIds = json_decode($soId);

        $quoteId = $request->input('selected_quote');
        $quoteIds = json_decode($quoteId);
   
        $loggedInUser = auth()->user();
        $namauser = $loggedInUser->nama;
        $nohp = $loggedInUser->no_hp;
        $email = $loggedInUser-> email;
        $userid = $loggedInUser->id;
        
        $po = new PurchaseOrder;

        $ponumber = $poNumbers[$kodeSupplier][0]; 

        $existingdata = PurchaseOrder::where('no_po', $ponumber)->first();

        if($existingdata !== null && $existingdata) {
            $request->session()->flash('error', "Data gagal disimpan, PO sudah ada");
            return redirect()->route('admininvoice.po.index');
        }

        $po->no_po = $poNumbers[$kodeSupplier][0]; 
        $po->po_date = $request->po_date;
        $po->user_id = $userid;
        $po->nama_user = $namauser;
        $po->email = $email;
        $po->no_hp = $nohp;
        $po -> kode_supplier = $kodeSupplier;
        $po -> kode_channel = "BPM";
        $po -> month = $month;
                $po -> created_by = $loggedInUsername;
     $po -> save();
       $poId = $po->id;
       $datapo = PurchaseOrder::find($poId);

       $coba = $request->produk[$kodeSupplier];
    

       $poDetails = [];
foreach ($request->produk[$kodeSupplier] as $index => $productId) {

        
    $product = Produk::find($productId); // Mendapatkan data produk dari basis data

    $qty = $quantities[$kodeSupplier][$index];
    $harga = $prices[$kodeSupplier][$index];
    $diskon = $discount[$kodeSupplier][$index];

    $totalprice = $qty * $harga;

    $amount = ($diskon/100) * $totalprice;

    $totalafter = $totalprice - $amount;

    if ($product) {
        $poDetails[] = [
            'po_id' => $poId,
            'product_id' => $productId,
            'qty' => $qty,
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
            'discount' => $diskon,
            'amount' => $amount,
            'total_price_after_discount' => $totalafter,
           
        ];
    }
    
}

DetailPO::insert($poDetails); 
$soIds = $soIds ?? [];
$quoteIds = $quoteIds ?? [];

// Gabungkan kedua array jika keduanya memiliki nilai yang valid
$mergedIds = array_merge($soIds, $quoteIds);


foreach ($mergedIds as $id) {

            if (in_array($id, $soIds)) {
                // ID adalah dari jenis Sales Order
                $so = SalesOrder::find($id);
                $so->status_so = "Terbit PO";
                $so->save();
        
                DetailSoPo::create([
                  'po_id' => $poId,
                    'so_id' => $id,
                    'quote_id' => null,
                    'rfo_id' => $so->rfo_id,
                    'no_so' => $so->no_so,
                    'no_po' => $datapo->no_po,
                    'no_rfo' => $so->no_rfo,
                    'kode_supplier' => $so->kode_supplier,
                    
                ]);
        
                $rfo = RFO::find($so->rfo_id);
                $rfo->status_rfo = "Proses PO";
                $rfo->save();
            } elseif (in_array($id, $quoteIds)) {
                // ID adalah dari jenis Quote
                $quote = Quotation::find($id);
                // Lakukan apa pun yang diperlukan untuk mengelola Quote
                $quote->status_quote = "Proses PO";
                $quote->save();

                DetailSoPo::create([
                  'po_id' => $poId,
                    'so_id' => null,
                    'quote_id' => $id,
                    'rfo_id' => null,
                    'no_so' => null,
                    'no_po' => $datapo->no_po,
                    'no_rfo' => null,
                    'no_quote' => $quote -> no_quote,
                    'kode_supplier' => $quote->kode_supplier,
                ]);

              
                // Lakukan logika lain yang diperlukan untuk Quote
            }
        }
}


    
    // Setelah selesai iterasi foreach, lakukan penyimpanan detail pembelian untuk setiap nomor PO yang telah dikumpulkan
  

     
        

 
        


 
    $request->session()->flash('success', "Purchase order berhasil dibuat.");

    return redirect()->route('superadmin.po.index');
  

     }
     public function tampilpo($id){
        $po = PurchaseOrder::find($id);
        $detailpo = DetailPO::with('purchaseorder')->where('po_id', $id)->get();

        $subtotal = 0;
    foreach ($detailpo as $detail) {
        $subtotal += $detail->total_price;
    }

    $totalqty = 0;
    foreach ($detailpo as $detail) {
        $totalqty += $detail->qty;
    }

    $totaldisk = 0;

  foreach ($detailpo as $detail) {
        $totaldisk += $detail->amount;
    }

    $totalpriceafter = 0;

    foreach ($detailpo as $detail) {
          $totalpriceafter += $detail->total_price_after_discount;
      }

        return view ('admininvoice.po.tampilpo',[
            'po' => $po, 
            'detailpo' => $detailpo,
            'subtotal' => $subtotal,
            'totalqty' => $totalqty,
            'totaldisk' => $totaldisk,
            'totalpriceafter' => $totalpriceafter,

        ]);

     }

     public function superadmintampilpo($id){
        $po = PurchaseOrder::find($id);
        $detailpo = DetailPO::with('purchaseorder')->where('po_id', $id)->get();

        $subtotal = 0;
    foreach ($detailpo as $detail) {
        $subtotal += $detail->total_price;
    }

    $totalqty = 0;
    foreach ($detailpo as $detail) {
        $totalqty += $detail->qty;
    }

    $totaldisk = 0;

  foreach ($detailpo as $detail) {
        $totaldisk += $detail->amount;
    }

    $totalpriceafter = 0;

    foreach ($detailpo as $detail) {
          $totalpriceafter += $detail->total_price_after_discount;
      }

        return view ('superadmin.po.tampilpo',[
            'po' => $po, 
            'detailpo' => $detailpo,
            'subtotal' => $subtotal,
            'totalqty' => $totalqty,
            'totaldisk' => $totaldisk,
            'totalpriceafter' => $totalpriceafter,

        ]);

     }
     public function download(Request $request, $id)
     {
         // Mengambil sales order dari database berdasarkan ID
         $po = PurchaseOrder::findOrFail($id);
     
         // Menandai bahwa sales order telah diunduh
         $po->is_download = true;
     
         // Menyimpan sales order tanpa mempengaruhi updated_at
         $po->save(['timestamps' => false]);
     
         // Mengembalikan respons sebagai JSON jika diperlukan
         return response()->json(['message' => 'Sales order has been downloaded successfully']);
     }
     
     public function cancelpo(Request $request){
        $so = SalesOrder::orderBy('created_at', 'desc')->get();
        
        $poid = $request->po_id;
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama;
        $podata = PurchaseOrder::find($request->po_id);


        if ($podata) {
            $podata->status_po = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $podata->save();
        }


        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        
        $cancelreq = new CancelApprovalSA;
        $cancelreq -> po_id = $request->po_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> report_to = $report;
        $cancelreq -> diajukan_oleh = $loggedInUsername;
    
        $cancelreq -> save();

        $request->session()->flash('success', "Cancel purchase order terkirim.");
        return redirect(route('admininvoice.po.index',[
            'so' => $so,
        ]));

     }
     public function superadmincancelpo(Request $request){
        
        $po = PurchaseOrder::orderBy('created_at', 'desc')->get();
        $poid = $request -> po_id;
        $podata = PurchaseOrder::find($poid);
        $kodesupplier = $podata -> kode_supplier;
        $detaildata = DetailSoPo::where('po_id', $poid)->where('kode_supplier', $kodesupplier)->get();

        foreach ($detaildata as $item){
            if($item->quote_id) {
                $qid = $item->quote_id;
                $quote = Quotation::find($qid);

                $quote->status_quote = "Quotation Dibuat";
                $quote->save();

            } elseif ($item -> so_id) {
                
                $soid = $item->so_id;
                $so = SalesOrder::find($soid);

                $so->status_so = "PO Belum Dikerjakan";
                $so->save();

            }
        }

  $podata = PurchaseOrder::find($poid);
        $podata -> status_po = "Cancelled";
        $podata -> save();

$request->session()->flash('success', "Purchase order berhasil dibatalkan.");

return redirect(route('superadmin.po.index',[
    'po' => $po,
]));

     }
     public function cancelpobatal(Request $request){

        $poid = $request -> po_id;
        
        $detaildata = DetailSoPo::where('po_id', $poid)->get();

        foreach ($detaildata as $item){
            if($item->quote_id) {
                $qid = $item->quote_id;
                $quote = Quotation::find($qid);

                $quote->status_quote = "Quotation Dibuat";
                $quote->save();

            } elseif ($item -> so_id) {
                
                $soid = $item->so_id;
                $so = SalesOrder::find($soid);

                $so->status_so = "PO Belum Dikerjakan";
                $so->save();

            }
        }

        $podata = PurchaseOrder::find($poid);
        $podata -> status_po = "Cancelled";
        $podata -> save();

        $request->session()->flash('success', "Purchase order berhasil dibatalkan.");

        return redirect()->route('admininvoice.po.index');
     }


     public function showso()
     {
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->get();
        $quote = Quotation::where('status_quote','Quotation Dibuat')->orderBy('created_at', 'desc')->get();

        return view('admininvoice.po.showso',[
            'so' => $so,
            'quote' => $quote,
        ]);
     }


     public function superadminshowso()
     {
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->get();
        $quote = Quotation::where('status_quote','Quotation Dibuat')->orderBy('created_at', 'desc')->get();

        return view('superadmin.po.showso',[
            'so' => $so,
            'quote' => $quote,
        ]);
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
