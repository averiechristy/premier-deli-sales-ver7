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

    if ($product) {
        $poDetails[] = [
            'po_id' => $po->id,
            'product_id' => $productId,
            'qty' => $request->quantity[$index],
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
        ];
    }
    
}

DetailPO::insert($poDetails); 

$request->session()->flash('success', "Purchase Order berhasil dibuat");

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
    $totalprice = $qty * $harga;

    if ($product) {
        $poDetails[] = [
            'po_id' => $po->id,
            'product_id' => $productId,
            'qty' => $request->quantity[$index],
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
        ];
    }
    
}

DetailPO::insert($poDetails); 

$request->session()->flash('success', "Purchase Order berhasil dibuat");

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

     public function admininvoicecreate(Request $request)
    {
        $selectedQuotes = $request->input('selected_po');
        $selectedSOs = $request->input('selected_so');

        $poterakhir = PurchaseOrder::latest()->first();
        
     
      
        
       if ($selectedSOs) {
    $soDetail = [];

    foreach ($selectedSOs as $selectedSO) {
        // Ambil detail SO dari database atau sumber data lainnya
        $details = DetailSO::where('so_id', $selectedSO)->get();


        // Membagi detail berdasarkan kode_supplier
        foreach ($details as $detail) {
          
            $kodeSupplier = $detail->kode_supplier;
            $kodechannel = $detail ->kode_channel;
          

          

            // Langkah-langkah untuk menghasilkan nomor PO yang sesuai dengan kode_supplier
            $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodeSupplier)->latest()->first(); // Mendapatkan data PO terakhir dari database untuk kode_supplier tertentu
            // Langkah-langkah untuk menghasilkan nomor urutan
            $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
            $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
            $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

            // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
            if ($lastpo) {
                $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
                $lastMonth = substr($lastpo->no_po, 16, -5); // Mendapatkan bulan dari nomor PO terakhir
                $lastMonthIndex = array_search($lastMonth, $romanMonth); // Mendapatkan indeks bulan romawi dari nomor PO terakhir
           
          
            } else {
                $lastYear = '0000';
                $lastMonthIndex = false;
            }

            // Langkah-langkah untuk membuat nomor PO baru
            if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
                // maka nomor urutan direset menjadi 1
                $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            } else {
                // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
                // maka nomor urutan diincrement
                $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
                $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            }

            // Tambahkan nomor PO ke dalam array
            if (!isset($soDetail[$kodeSupplier])) {
                $soDetail[$kodeSupplier] = [
                    'po_number' => $ponumber, // Menambahkan nomor PO untuk setiap kode_supplier
                    'items' => [] // Menyiapkan array untuk menyimpan detail produk
                ];
            }

            $index = array_search($detail->product_id, array_column($soDetail[$kodeSupplier]['items'], 'produk_id'));

            if ($index !== false) {
                // Produk sudah ada dalam array, tambahkan jumlahnya
                $soDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
            } else {
                // Produk belum ada dalam array, tambahkan produk baru
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

    // Output untuk melihat hasil penggabungan dan penjumlahan
 
}

        
if ($selectedQuotes) {
    $quoteDetail = [];

    foreach ($selectedQuotes as $selectedQuote) {
        // Ambil detail quotation dari database atau sumber data lainnya
        $details = DetailQuotation::where('quote_id', $selectedQuote)->get();

        // Membagi detail berdasarkan kode_supplier
        foreach ($details as $detail) {
            $kodeSupplier = $detail->kode_supplier;

            // Langkah-langkah untuk menghasilkan nomor PO yang sesuai dengan kode_supplier
            $lastpo = PurchaseOrder::where('kode_supplier', $kodeSupplier)->latest()->first(); // Mendapatkan data PO terakhir dari database untuk kode_supplier tertentu

            // Langkah-langkah untuk menghasilkan nomor urutan
            $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
            $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
            $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

            // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
            if ($lastpo) {
                $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
                $lastMonth = substr($lastpo->no_po, 16, -5); // Mendapatkan bulan dari nomor PO terakhir
                $lastMonthIndex = array_search($lastMonth, $romanMonth); 
                
            } else {
                $lastYear = '0000';
                $lastMonthIndex = false;
            }

            // Langkah-langkah untuk membuat nomor PO baru
            if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
                // maka nomor urutan direset menjadi 1
                $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            } else {
                // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
                // maka nomor urutan diincrement
                $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
                $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            }

            // Tambahkan nomor PO ke dalam array
            if (!isset($quoteDetail[$kodeSupplier])) {
                $quoteDetail[$kodeSupplier] = [
                    'po_number' => $ponumber, // Menambahkan nomor PO untuk setiap kode_supplier
                    'items' => [] // Menyiapkan array untuk menyimpan detail produk
                ];
            }

            $index = array_search($detail->product_id, array_column($quoteDetail[$kodeSupplier]['items'], 'produk_id'));

            if ($index !== false) {
                // Produk sudah ada dalam array, tambahkan jumlahnya
                $quoteDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
            } else {
                // Produk belum ada dalam array, tambahkan produk baru
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

    // Output untuk melihdd($quoteDetail);
}

        if ($selectedSOs && !$selectedQuotes) {
            $mergedDetail = $soDetail;
        }

        if (!$selectedSOs && $selectedQuotes) {
            $mergedDetail = $quoteDetail;
        }

        if ($selectedSOs && $selectedQuotes) {

           
            $mergedDetail = [];
    
    // Gabungkan array berdasarkan kunci $kodeSupplier
    foreach ($soDetail as $kodeSupplier => $details) {
        // Gabungkan detail dari $soDetail
        if (isset($mergedDetail[$kodeSupplier])) {
            $mergedDetail[$kodeSupplier] = array_merge($mergedDetail[$kodeSupplier], $details);
        } else {
            $mergedDetail[$kodeSupplier] = $details;
        }
      
        // Gabungkan detail dari $quoteDetail
        if (isset($quoteDetail[$kodeSupplier])) {

         
            foreach ($quoteDetail[$kodeSupplier]['items'] as $quoteDetailItem) {
                // Access product details directly
            
                
                $index = array_search($quoteDetailItem['produk_id'], array_column($mergedDetail[$kodeSupplier]['items'], 'produk_id'));

    if ($index !== false) {
        // Jika produk sudah ada dalam array, tambahkan jumlahnya
        $mergedDetail[$kodeSupplier]['items'][$index]['quantity'] += $quoteDetailItem['quantity'];
    } else {
        // Jika produk belum ada dalam array, tambahkan produk baru
        $mergedDetail[$kodeSupplier]['items'][] = $quoteDetailItem;
    }
                
            }
            
        } 

        foreach ($quoteDetail as $kodeSupplier => $quoteDetails) {
            if (!isset($soDetail[$kodeSupplier])) {
                $mergedDetail[$kodeSupplier] = $quoteDetails;
            }
        }
    }


            }
       

       
        $produk = Produk::orderBy('nama_produk', 'asc')->get();
        
      
         return view('admininvoice.po.create', [
            'produk' => $produk,

            'selectedSOs' => $selectedSOs,
            'selectedQuotes' => $selectedQuotes,
            'mergedDetail' => $mergedDetail,
    
            
         ]);
     }

     public function superadmincreate(Request $request)
     {

        $selectedQuotes = $request->input('selected_po');
        $selectedSOs = $request->input('selected_so');

        $poterakhir = PurchaseOrder::latest()->first();
     
       
        
       if ($selectedSOs) {
    $soDetail = [];

    foreach ($selectedSOs as $selectedSO) {
        // Ambil detail SO dari database atau sumber data lainnya
        $details = DetailSO::where('so_id', $selectedSO)->get();


        // Membagi detail berdasarkan kode_supplier
        foreach ($details as $detail) {
          
            $kodeSupplier = $detail->kode_supplier;
            $kodechannel = $detail ->kode_channel;

          

            // Langkah-langkah untuk menghasilkan nomor PO yang sesuai dengan kode_supplier
            $lastpo = PurchaseOrder::where('kode_channel', $kodechannel)->where('kode_supplier', $kodeSupplier)->latest()->first(); // Mendapatkan data PO terakhir dari database untuk kode_supplier tertentu
            // Langkah-langkah untuk menghasilkan nomor urutan
            $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
            $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
            $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

            // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
            if ($lastpo) {
                $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
                $lastMonth = substr($lastpo->no_po, 16, -5); // Mendapatkan bulan dari nomor PO terakhir
                $lastMonthIndex = array_search($lastMonth, $romanMonth); // Mendapatkan indeks bulan romawi dari nomor PO terakhir
           
          
            } else {
                $lastYear = '0000';
                $lastMonthIndex = false;
            }

            // Langkah-langkah untuk membuat nomor PO baru
            if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
                // maka nomor urutan direset menjadi 1
                $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            } else {
                // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
                // maka nomor urutan diincrement
                $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
                $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            }

            // Tambahkan nomor PO ke dalam array
            if (!isset($soDetail[$kodeSupplier])) {
                $soDetail[$kodeSupplier] = [
                    'po_number' => $ponumber, // Menambahkan nomor PO untuk setiap kode_supplier
                    'items' => [] // Menyiapkan array untuk menyimpan detail produk
                ];
            }

            $index = array_search($detail->product_id, array_column($soDetail[$kodeSupplier]['items'], 'produk_id'));

            if ($index !== false) {
                // Produk sudah ada dalam array, tambahkan jumlahnya
                $soDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
            } else {
                // Produk belum ada dalam array, tambahkan produk baru
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

    // Output untuk melihat hasil penggabungan dan penjumlahan
 
}

        
if ($selectedQuotes) {
    $quoteDetail = [];

    foreach ($selectedQuotes as $selectedQuote) {
        // Ambil detail quotation dari database atau sumber data lainnya
        $details = DetailQuotation::where('quote_id', $selectedQuote)->get();

        // Membagi detail berdasarkan kode_supplier
        foreach ($details as $detail) {
            $kodeSupplier = $detail->kode_supplier;

            // Langkah-langkah untuk menghasilkan nomor PO yang sesuai dengan kode_supplier
            $lastpo = PurchaseOrder::where('kode_supplier', $kodeSupplier)->latest()->first(); // Mendapatkan data PO terakhir dari database untuk kode_supplier tertentu

            // Langkah-langkah untuk menghasilkan nomor urutan
            $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
            $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
            $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi

            // Langkah-langkah untuk menentukan nomor urutan berdasarkan PO sebelumnya
            if ($lastpo) {
                $lastYear = substr($lastpo->no_po, -4); // Mendapatkan 4 digit tahun dari nomor PO terakhir
                $lastMonth = substr($lastpo->no_po, 16, -5); // Mendapatkan bulan dari nomor PO terakhir
                $lastMonthIndex = array_search($lastMonth, $romanMonth); 
                
            } else {
                $lastYear = '0000';
                $lastMonthIndex = false;
            }

            // Langkah-langkah untuk membuat nomor PO baru
            if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
                // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
                // maka nomor urutan direset menjadi 1
                $ponumber = '0001/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            } else {
                // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
                // maka nomor urutan diincrement
                $lastOrder = intval(substr($lastpo->no_po, 0, 4)); // Mendapatkan nomor urutan terakhir
                $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/BPM-' . $kodeSupplier . '/' . $romanMonth[$currentMonth] . '/' . $currentYear;
            }

            // Tambahkan nomor PO ke dalam array
            if (!isset($quoteDetail[$kodeSupplier])) {
                $quoteDetail[$kodeSupplier] = [
                    'po_number' => $ponumber, // Menambahkan nomor PO untuk setiap kode_supplier
                    'items' => [] // Menyiapkan array untuk menyimpan detail produk
                ];
            }

            $index = array_search($detail->product_id, array_column($quoteDetail[$kodeSupplier]['items'], 'produk_id'));

            if ($index !== false) {
                // Produk sudah ada dalam array, tambahkan jumlahnya
                $quoteDetail[$kodeSupplier]['items'][$index]['quantity'] += $detail->qty;
            } else {
                // Produk belum ada dalam array, tambahkan produk baru
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

    // Output untuk melihdd($quoteDetail);
}

        if ($selectedSOs && !$selectedQuotes) {
            $mergedDetail = $soDetail;
        }

        if (!$selectedSOs && $selectedQuotes) {
            $mergedDetail = $quoteDetail;
        }

        if ($selectedSOs && $selectedQuotes) {

           
            $mergedDetail = [];
    
    // Gabungkan array berdasarkan kunci $kodeSupplier
    foreach ($soDetail as $kodeSupplier => $details) {
        // Gabungkan detail dari $soDetail
        if (isset($mergedDetail[$kodeSupplier])) {
            $mergedDetail[$kodeSupplier] = array_merge($mergedDetail[$kodeSupplier], $details);
        } else {
            $mergedDetail[$kodeSupplier] = $details;
        }
      
        // Gabungkan detail dari $quoteDetail
        if (isset($quoteDetail[$kodeSupplier])) {

         
            foreach ($quoteDetail[$kodeSupplier]['items'] as $quoteDetailItem) {
                // Access product details directly
            
                $index = array_search($quoteDetailItem['produk_id'], array_column($mergedDetail[$kodeSupplier]['items'], 'produk_id'));

    if ($index !== false) {
        // Jika produk sudah ada dalam array, tambahkan jumlahnya
        $mergedDetail[$kodeSupplier]['items'][$index]['quantity'] += $quoteDetailItem['quantity'];
    } else {
        // Jika produk belum ada dalam array, tambahkan produk baru
        $mergedDetail[$kodeSupplier]['items'][] = $quoteDetailItem;
    }
         
            }
            
        } 

        foreach ($quoteDetail as $kodeSupplier => $quoteDetails) {
            if (!isset($soDetail[$kodeSupplier])) {
                $mergedDetail[$kodeSupplier] = $quoteDetails;
            }
        }
    }
            }
         
        $produk = Produk::orderBy('nama_produk', 'asc')->get();
        
         return view('superadmin.po.create', [
            'produk' => $produk,

            'selectedSOs' => $selectedSOs,
            'selectedQuotes' => $selectedQuotes,
            'mergedDetail' => $mergedDetail,
    
            
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

    if ($product) {
        $poDetails[] = [
            'po_id' => $poId,
            'product_id' => $productId,
            'qty' => $qty,
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
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
  

     
        

 
        


 
    $request->session()->flash('success', "Purchase Order berhasil dibuat");

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

    if ($product) {
        $poDetails[] = [
            'po_id' => $poId,
            'product_id' => $productId,
            'qty' => $qty,
            'nama_produk' => $product->nama_produk, // Menyimpan nama_produk
            'kode_produk' => $product->kode_produk, // Menyimpan kode_produk
            'po_price' => $product->harga_beli, // Menyimpan kode_produk
            'total_price' => $totalprice,
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
  

     
        

 
        


 
    $request->session()->flash('success', "Purchase Order berhasil dibuat");

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


        return view ('admininvoice.po.tampilpo',[
            'po' => $po, 
            'detailpo' => $detailpo,
            'subtotal' => $subtotal,
            'totalqty' => $totalqty,
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


        return view ('superadmin.po.tampilpo',[
            'po' => $po, 
            'detailpo' => $detailpo,
            'subtotal' => $subtotal,
            'totalqty' => $totalqty,
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
    
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
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

$request->session()->flash('success', "Purchase Order berhasil dibatalkan");

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

        $request->session()->flash('success', "Purchase Order berhasil dibatalkan");

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
