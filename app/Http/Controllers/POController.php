<?php

namespace App\Http\Controllers;

use App\Models\CancelApprovalSA;
use App\Models\DetailPO;
use App\Models\DetailQuotation;
use App\Models\DetailSO;
use App\Models\DetailSoPo;
use App\Models\Produk;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RFO;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class POController extends Controller
{
    /**
     * Display a listing of the resource.
     */

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

        $selectedSOs = $request->input('selected_so');
        $selectedQuote = $request->input('selected_po');

        
        if ($selectedQuote){
            $quoteDetail = [];
            
            foreach ($selectedQuote as $selectedquotation) {
                // Ambil detail SO dari database atau sumber data lainnya
                $detail = DetailQuotation::where('quote_id', $selectedquotation)->get();
                if ($detail->isNotEmpty()) {

                    foreach ($detail as $item) {
                        $product_id = $item->product_id;
                        if (!isset($quoteDetail[$product_id])) {
                            // Jika product_id belum ada dalam array, inisialisasi dengan array kosong
                            $quoteDetail[$product_id] = [
                                'product_id' => $item->product_id,
                                'nama_produk' => $item->nama_produk,
                                'kode_produk' => $item->kode_produk,
                                'qty' => 0,
                                'harga_beli' => 0 // Inisialisasi harga beli dengan nilai default
                            ];
                        }
                        // Tambahkan qty dari produk yang sama
                        $quoteDetail[$product_id]['qty'] += $item->qty;
                        
                        // Ambil harga beli dari model Produk
                        $produk = Produk::find($product_id);
                        if ($produk) {

                            $quoteDetail[$product_id]['harga_beli'] = $produk->harga_beli;
                        }
                    }
                }
            }
            $quoteDetail = array_values($quoteDetail);
        }

        if ($selectedSOs){
        $soDetail = [];
        
        foreach ($selectedSOs as $selectedSO) {
            // Ambil detail SO dari database atau sumber data lainnya
            $detail = DetailSO::where('so_id', $selectedSO)->get();
            if ($detail->isNotEmpty()) {
                // Tambahkan detail SO ke dalam array $soDetail
                foreach ($detail as $item) {
                    $product_id = $item->product_id;
                    if (!isset($soDetail[$product_id])) {
                        // Jika product_id belum ada dalam array, inisialisasi dengan array kosong
                        $soDetail[$product_id] = [
                            'product_id' => $item->product_id,
                            'nama_produk' => $item->nama_produk,
                            'kode_produk' => $item->kode_produk,
                            'qty' => 0,
                            'harga_beli' => 0 // Inisialisasi harga beli dengan nilai default
                        ];
                    }
                    // Tambahkan qty dari produk yang sama
                    $soDetail[$product_id]['qty'] += $item->qty;
                    
                    // Ambil harga beli dari model Produk
                    $produk = Produk::find($product_id);
                    if ($produk) {
                        // Jika produk ditemukan, tambahkan informasi harga beli ke dalam array $soDetail
                        $soDetail[$product_id]['harga_beli'] = $produk->harga_beli;
                    }
                }
            }
        }
          
        $soDetail = array_values($soDetail);
    }
        // Ubah array asosiatif menjadi array numerik
        if ($selectedSOs && !$selectedQuote) {
            $mergedDetail = $soDetail;
        }

        if (!$selectedSOs && $selectedQuote) {
            $mergedDetail = $quoteDetail;
        }

        if ($selectedSOs && $selectedQuote) {
        // Inisialisasi array untuk hasil penggabungan
$mergedDetail = [];

// Menggabungkan detail dari Quote
foreach ($quoteDetail as $quoteItem) {
    $productId = $quoteItem['product_id'];
    
    if (!isset($mergedDetail[$productId])) {
        // Jika product_id belum ada dalam array gabungan, inisialisasi dengan array kosong
        $mergedDetail[$productId] = [
            'product_id' => $quoteItem['product_id'],
            'nama_produk' => $quoteItem['nama_produk'],
            'kode_produk' => $quoteItem['kode_produk'],
            'qty' => $quoteItem['qty'],
            'harga_beli' => $quoteItem['harga_beli']
        ];
    } else {
        // Jika product_id sudah ada, tambahkan qty
        $mergedDetail[$productId]['qty'] += $quoteItem['qty'];
    }
}

// Menggabungkan detail dari Sales Order
foreach ($soDetail as $soItem) {
    $productId = $soItem['product_id'];
    
    if (!isset($mergedDetail[$productId])) {
        // Jika product_id belum ada dalam array gabungan, inisialisasi dengan array kosong
        $mergedDetail[$productId] = [
            'product_id' => $soItem['product_id'],
            'nama_produk' => $soItem['nama_produk'],
            'kode_produk' => $soItem['kode_produk'],
            'qty' => $soItem['qty'],
            'harga_beli' => $soItem['harga_beli']
        ];
    } else {
        // Jika product_id sudah ada, tambahkan qty
        $mergedDetail[$productId]['qty'] += $soItem['qty'];
    }
}

// Ubah array asosiatif menjadi array numerik
$mergedDetail = array_values($mergedDetail);
        }

         // Mengambil semua Sales Order
        

         $lastpo = PurchaseOrder::latest()->first(); // Mendapatkan data invoice terakhir dari database

         $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
         $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
         $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi
         
         $lastYear = $lastpo ? substr($lastpo->no_po, 20, 4) : '0000'; // Mendapatkan 4 digit tahun dari nomor PO terakhir
         $lastMonth = $lastpo ? substr($lastpo->no_po, 16, -5) : '00'; 
         
         
         $lastMonthIndex = array_search($lastMonth, $romanMonth); // Mendapatkan indeks bulan romawi dari nomor PO terakhir


         
         
         if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
             // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
             // maka nomor urutan direset menjadi 1
             $ponumber = '0001/PO/EXA-PSA/' . $romanMonth[$currentMonth] . '/' . $currentYear;
         } else {
             // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
             // maka nomor urutan diincrement
             $lastOrder = $lastpo ? intval(substr($lastpo->no_po, 0, 4)) : 0; // Mendapatkan nomor urutan terakhir
             $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/EXA-PSA/' . $romanMonth[$currentMonth] . '/' . $currentYear; // Menggabungkan nomor urutan dengan PO/EXA-PSA/bulan berjalan (dalam huruf romawi)/tahun 4 digit
         }     
         $produk = Produk::orderBy('nama_produk', 'asc')->get();
        
        
         return view('admininvoice.po.create', [
        
            'ponumber' => $ponumber,
            'produk' => $produk,
            
            'selectedSOs' => $selectedSOs,
            'mergedDetail' => $mergedDetail,
            'selectedQuote' => $selectedQuote,
         ]);
     }

     public function superadmincreate(Request $request)
     {

        $selectedSOs = $request->input('selected_so');
        $selectedQuote = $request->input('selected_po');

        
        if ($selectedQuote){
            $quoteDetail = [];
            
            foreach ($selectedQuote as $selectedquotation) {
                // Ambil detail SO dari database atau sumber data lainnya
                $detail = DetailQuotation::where('quote_id', $selectedquotation)->get();
                if ($detail->isNotEmpty()) {

                    foreach ($detail as $item) {
                        $product_id = $item->product_id;
                        if (!isset($quoteDetail[$product_id])) {
                            // Jika product_id belum ada dalam array, inisialisasi dengan array kosong
                            $quoteDetail[$product_id] = [
                                'product_id' => $item->product_id,
                                'nama_produk' => $item->nama_produk,
                                'kode_produk' => $item->kode_produk,
                                'qty' => 0,
                                'harga_beli' => 0 // Inisialisasi harga beli dengan nilai default
                            ];
                        }
                        // Tambahkan qty dari produk yang sama
                        $quoteDetail[$product_id]['qty'] += $item->qty;
                        
                        // Ambil harga beli dari model Produk
                        $produk = Produk::find($product_id);
                        if ($produk) {

                            $quoteDetail[$product_id]['harga_beli'] = $produk->harga_beli;
                        }
                    }
                }
            }
            $quoteDetail = array_values($quoteDetail);
        }

        if ($selectedSOs){
        $soDetail = [];
        
        foreach ($selectedSOs as $selectedSO) {
            // Ambil detail SO dari database atau sumber data lainnya
            $detail = DetailSO::where('so_id', $selectedSO)->get();
            if ($detail->isNotEmpty()) {
                // Tambahkan detail SO ke dalam array $soDetail
                foreach ($detail as $item) {
                    $product_id = $item->product_id;
                    if (!isset($soDetail[$product_id])) {
                        // Jika product_id belum ada dalam array, inisialisasi dengan array kosong
                        $soDetail[$product_id] = [
                            'product_id' => $item->product_id,
                            'nama_produk' => $item->nama_produk,
                            'kode_produk' => $item->kode_produk,
                            'qty' => 0,
                            'harga_beli' => 0 // Inisialisasi harga beli dengan nilai default
                        ];
                    }
                    // Tambahkan qty dari produk yang sama
                    $soDetail[$product_id]['qty'] += $item->qty;
                    
                    // Ambil harga beli dari model Produk
                    $produk = Produk::find($product_id);
                    if ($produk) {
                        // Jika produk ditemukan, tambahkan informasi harga beli ke dalam array $soDetail
                        $soDetail[$product_id]['harga_beli'] = $produk->harga_beli;
                    }
                }
            }
        }
          
        $soDetail = array_values($soDetail);
    }
        // Ubah array asosiatif menjadi array numerik
        if ($selectedSOs && !$selectedQuote) {
            $mergedDetail = $soDetail;
        }

        if (!$selectedSOs && $selectedQuote) {
            $mergedDetail = $quoteDetail;
        }

        if ($selectedSOs && $selectedQuote) {
        // Inisialisasi array untuk hasil penggabungan
$mergedDetail = [];

// Menggabungkan detail dari Quote
foreach ($quoteDetail as $quoteItem) {
    $productId = $quoteItem['product_id'];
    
    if (!isset($mergedDetail[$productId])) {
        // Jika product_id belum ada dalam array gabungan, inisialisasi dengan array kosong
        $mergedDetail[$productId] = [
            'product_id' => $quoteItem['product_id'],
            'nama_produk' => $quoteItem['nama_produk'],
            'kode_produk' => $quoteItem['kode_produk'],
            'qty' => $quoteItem['qty'],
            'harga_beli' => $quoteItem['harga_beli']
        ];
    } else {
        // Jika product_id sudah ada, tambahkan qty
        $mergedDetail[$productId]['qty'] += $quoteItem['qty'];
    }
}

// Menggabungkan detail dari Sales Order
foreach ($soDetail as $soItem) {
    $productId = $soItem['product_id'];
    
    if (!isset($mergedDetail[$productId])) {
        // Jika product_id belum ada dalam array gabungan, inisialisasi dengan array kosong
        $mergedDetail[$productId] = [
            'product_id' => $soItem['product_id'],
            'nama_produk' => $soItem['nama_produk'],
            'kode_produk' => $soItem['kode_produk'],
            'qty' => $soItem['qty'],
            'harga_beli' => $soItem['harga_beli']
        ];
    } else {
        // Jika product_id sudah ada, tambahkan qty
        $mergedDetail[$productId]['qty'] += $soItem['qty'];
    }
}

// Ubah array asosiatif menjadi array numerik
$mergedDetail = array_values($mergedDetail);
        }

         // Mengambil semua Sales Order
        

         $lastpo = PurchaseOrder::latest()->first(); // Mendapatkan data invoice terakhir dari database

         $currentYear = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
         $currentMonth = ltrim(now()->format('m'), '0'); // Mendapatkan dua digit bulan saat ini
         $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi
         
         $lastYear = $lastpo ? substr($lastpo->no_po, 20, 4) : '0000'; // Mendapatkan 4 digit tahun dari nomor PO terakhir
         $lastMonth = $lastpo ? substr($lastpo->no_po, 16, -5) : '00'; 
         
         
         $lastMonthIndex = array_search($lastMonth, $romanMonth); // Mendapatkan indeks bulan romawi dari nomor PO terakhir


         
         
         if ($lastMonthIndex === false || $currentYear != $lastYear || $currentMonth != $lastMonthIndex) {
             // Jika indeks bulan tidak ditemukan atau tahun atau bulan saat ini berbeda dengan tahun atau bulan dari nomor PO terakhir,
             // maka nomor urutan direset menjadi 1
             $ponumber = '0001/PO/EXA-PSA/' . $romanMonth[$currentMonth] . '/' . $currentYear;
         } else {
             // Jika tahun dan bulan saat ini sama dengan tahun dan bulan dari nomor PO terakhir,
             // maka nomor urutan diincrement
             $lastOrder = $lastpo ? intval(substr($lastpo->no_po, 0, 4)) : 0; // Mendapatkan nomor urutan terakhir
             $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/EXA-PSA/' . $romanMonth[$currentMonth] . '/' . $currentYear; // Menggabungkan nomor urutan dengan PO/EXA-PSA/bulan berjalan (dalam huruf romawi)/tahun 4 digit
         }     
     
         $produk = Produk::orderBy('nama_produk', 'asc')->get();
        
        
         return view('superadmin.po.create', [
        
            'ponumber' => $ponumber,
            'produk' => $produk,
            
            'selectedSOs' => $selectedSOs,
            'mergedDetail' => $mergedDetail,
            'selectedQuote' => $selectedQuote,
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
        $po->no_po = $request-> no_po;
        $po->po_date = $request->po_date;
        $po->user_id = $userid;
        $po->nama_user = $namauser;
        $po->email = $email;
        $po->no_hp = $nohp;
        
       
        $po->save();

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
                    'po_id' => $po->id,
                    'so_id' => $id,
                    'quote_id' => null,
                    'rfo_id' => $so->rfo_id,
                    'no_so' => $so->no_so,
                    'no_po' => $po->no_po,
                    'no_rfo' => $so->no_rfo
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
                    'po_id' => $po->id,
                    'so_id' => null,
                    'quote_id' => $id,
                    'rfo_id' => null,
                    'no_so' => null,
                    'no_po' => $po->no_po,
                    'no_rfo' => null,
                    'no_quote' => $quote -> no_quote,
                ]);

              
                // Lakukan logika lain yang diperlukan untuk Quote
            }
        }
        

 
        
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
     
     public function superadminsimpan (Request $request){

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
        $po->no_po = $request-> no_po;
        $po->po_date = $request->po_date;
        $po->user_id = $userid;
        $po->nama_user = $namauser;
        $po->email = $email;
        $po->no_hp = $nohp;
        
       
        $po->save();

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
                    'po_id' => $po->id,
                    'so_id' => $id,
                    'quote_id' => null,
                    'rfo_id' => $so->rfo_id,
                    'no_so' => $so->no_so,
                    'no_po' => $po->no_po,
                    'no_rfo' => $so->no_rfo
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
                    'po_id' => $po->id,
                    'so_id' => null,
                    'quote_id' => $id,
                    'rfo_id' => null,
                    'no_so' => null,
                    'no_po' => $po->no_po,
                    'no_rfo' => null,
                    'no_quote' => $quote -> no_quote,
                ]);

              
                // Lakukan logika lain yang diperlukan untuk Quote
            }
        }
        

 
        
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
