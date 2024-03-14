<?php

namespace App\Http\Controllers;

use App\Models\DetailPO;
use App\Models\DetailSO;
use App\Models\DetailSoPo;
use App\Models\Produk;
use App\Models\PurchaseOrder;
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

        return view ('admininvoice.po.index',[
            'po' => $po,
        ]);
     }

     public function admininvoicecreate(Request $request)
     {

       

        $selectedSOs = $request->input('selected_so');
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
        
        // Ubah array asosiatif menjadi array numerik
        $soDetail = array_values($soDetail);
        
   
        
         // Mengambil semua Sales Order
        

         $lastpo = PurchaseOrder::latest()->first(); // Mendapatkan data invoice terakhir dari database

         $year = now()->format('Y'); // Mendapatkan 4 digit tahun saat ini
         $month = ltrim(now()->format('m'), '0');
         // Mendapatkan dua digit bulan saat ini
         $romanMonth = array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"); // Array untuk mengubah bulan menjadi huruf romawi
         $lastOrder = $lastpo ? substr($lastpo->no_po, 0, 4) : 0; // Mendapatkan nomor urutan terakhir dari nomor invoice terakhir
     
     
        
         $ponumber = str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT) . '/PO/EXA-PSA/' . $romanMonth[$month] . '/' . $year; // Menggabungkan nomor invoice dengan PO/EXA-PSA/bulan berjalan(dalam huruf romawi)/tahun 4 digit
     
         $produk = Produk::orderBy('nama_produk', 'asc')->get();
        
        
         return view('admininvoice.po.create', [
        
            'ponumber' => $ponumber,
            'produk' => $produk,
            'soDetail' => $soDetail,
            'selectedSOs' => $selectedSOs,
         ]);
     }
     
     public function admininvoicesimpan (Request $request){

        $soId = $request->input('selected_so');
        $soIds = json_decode($soId);

      
       
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

    
        foreach ($soIds as $soId) {
            $so = SalesOrder::find($soId); // Mengambil SO berdasarkan ID (gantilah SO dengan model SO yang sesuai)
            $so->status_so = "Terbit PO"; // Mengubah status SO menjadi "Terbit PO"
            $so->save();
    
            DetailSoPo::create([
                'po_id' => $po->id,
                'so_id' => $soId,
                'rfo_id' => $so->rfo_id, // Menyimpan nilai rfo_id dari SO
                'no_so' => $so->no_so, // Menyimpan nomor SO
                'no_po' => $po->no_po, // Menyimpan nomor PO
                'no_rfo' => $so->rfo->no_rfo // Mengambil nomor rfo_id dari SO dan kemudian mencari nomor rfo dari model RFO
            ]);
    
            // Mengubah status_rfo menjadi "Terbit PO" untuk RFO yang terkait
            $rfo = RFO::find($so->rfo_id);
            $rfo->status_rfo = "Proses PO";
            $rfo->save();
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

     public function showso()
     {
        $so = SalesOrder::where('status_so','PO Belum Dikerjakan')->orderBy('created_at', 'desc')->get();
        return view('admininvoice.po.showso',[
            'so' => $so,
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
