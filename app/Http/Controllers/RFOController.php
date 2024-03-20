<?php

namespace App\Http\Controllers;

use App\Models\CancelApproval;
use App\Models\Customer;
use App\Models\DetailRFO;
use App\Models\Produk;
use App\Models\RFO;
use App\Models\SalesOrder;
use App\Models\User;
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
    public function salesindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;

        $rfo = RFO::where('created_by',$userid )->orderBy('created_at', 'desc')->get();
        
        return view ('sales.rfo.index',[
            'rfo' => $rfo,
        ]);
    }

    public function leaderindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $sales = User::where('report_to', $userid)->get();

        $salesIds = $sales->pluck('id')->toArray();
       
        $rfo = RFO::where('created_by',$userid )->orderBy('created_at', 'desc')->get();

        $rfodarisales = RFO::whereIn('created_by', $salesIds)
        ->orderBy('created_at', 'desc')
        ->get();
       

        return view ('leader.rfo.index',[
            'rfodarisales' => $rfodarisales,
            'rfo' => $rfo,
        ]);
    }

    public function managerindex()
    {
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        $sales = User::where('report_to', $userid)->get();

        $salesIds = $sales->pluck('id')->toArray();
       
        $rfo = RFO::where('created_by',$userid )->orderBy('created_at', 'desc')->get();

        $rfodarisales = RFO::whereIn('created_by', $salesIds)
        ->orderBy('created_at', 'desc')
        ->get();
       
      
        return view ('manager.rfo.index',[
            'rfodarisales' => $rfodarisales,
            'rfo' => $rfo,
        ]);
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
    public function leadercreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastRFO = RFO::latest()->first(); // Mendapatkan data SO terakhir dari database

        $yearMonth = now()->format('ym'); // Mendapatkan format tahun dan bulan saat ini tanpa empat digit pertama (tahun)
        $lastOrder = $lastRFO ? substr($lastRFO->no_rfo, -4) : '0000'; // Mengambil empat digit terakhir dari nomor SO terakhir
        
        $orderNumber = 'RFO - ' . $yearMonth . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT); // Menggabungkan tahun, bulan, dan urutan
        
        
      
       
        return view('leader.rfo.create',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    }

    public function managercreate()
    {

        $customer = Customer::orderBy('nama_customer', 'asc')->get();
        $produk = Produk::orderBy('nama_produk', 'asc')->get();

        $lastRFO = RFO::latest()->first(); // Mendapatkan data SO terakhir dari database

        $yearMonth = now()->format('ym'); // Mendapatkan format tahun dan bulan saat ini tanpa empat digit pertama (tahun)
        $lastOrder = $lastRFO ? substr($lastRFO->no_rfo, -4) : '0000'; // Mengambil empat digit terakhir dari nomor SO terakhir
        
        $orderNumber = 'RFO - ' . $yearMonth . str_pad($lastOrder + 1, 4, '0', STR_PAD_LEFT); // Menggabungkan tahun, bulan, dan urutan
        
        
      
       
        return view('manager.rfo.create',[
            'customer' => $customer,
            'produk' => $produk,
            'orderNumber' => $orderNumber,
        ]);
    }
    public function salesstore(Request $request){
       
        $loggedInUser = auth()->user();

        $userid = $loggedInUser ->id;
        $nama = $loggedInUser -> nama;

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
        $rfo -> created_by = $userid;
        $rfo -> nama_pembuat = $nama;

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

        return redirect()->route('sales.rfo.index');
        
    }

    public function leaderstore(Request $request){
       
        $loggedInUser = auth()->user();

        $userid = $loggedInUser ->id;
        $nama = $loggedInUser -> nama;

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
        $rfo -> created_by = $userid;
        $rfo -> nama_pembuat = $nama;

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

        return redirect()->route('leader.rfo.index');
        
    }
    public function managerstore(Request $request){
       
        $loggedInUser = auth()->user();

        $userid = $loggedInUser ->id;
        $nama = $loggedInUser -> nama;

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
        $rfo -> created_by = $userid;
        $rfo -> nama_pembuat = $nama;

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

        return redirect()->route('manager.rfo.index');
        
    }

    public function admininvoiceindex(){
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        return view ('admininvoice.rfo.index',[
    'rfo' => $rfo,]);
    }


    
    public function superadminindex(){
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        return view ('superadmin.rfo.index',[
    'rfo' => $rfo,]);
    }
    /**
     * Show the form for creating a new resource.
     */

     public function cancelorder(Request $request){
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        

        $rfoid = $request->rfo_id;
        $loggedInUser = auth()->user();
        $rfodata = RFO::find($request->rfo_id);


        if ($rfodata) {
            $rfodata->status_rfo = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $rfodata->save();
        }


        $sodata = SalesOrder::where('rfo_id', $rfoid)->get();
        
        foreach ($sodata as $so) {
            $so -> status_so = "Menunggu Persetujuan Cancel";
            $so->save();
         }
         

        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        

        $cancelreq = new CancelApproval;
        $cancelreq -> rfo_id = $request->rfo_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> id_report = $report;
        $cancelreq -> report_role = $roleid;
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('sales.rfo.index',[
            'rfo' => $rfo,
        ]));

     }
     public function leadercancelorder(Request $request){
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        

        $rfoid = $request->rfo_id;
        $loggedInUser = auth()->user();
        $rfodata = RFO::find($request->rfo_id);


        if ($rfodata) {
            $rfodata->status_rfo = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $rfodata->save();
        }


        $sodata = SalesOrder::where('rfo_id', $rfoid)->get();
        
        foreach ($sodata as $so) {
            $so -> status_so = "Menunggu Persetujuan Cancel";
            $so->save();
         }
         

        $roleid = $loggedInUser -> role_id;
        $report = $loggedInUser -> report_to;
        
        

        $cancelreq = new CancelApproval;
        $cancelreq -> rfo_id = $request->rfo_id;
        $cancelreq -> role_id = $roleid;
        $cancelreq -> alasan = $request->alasan;
        $cancelreq -> id_report = $report;
        $cancelreq -> report_role = $roleid;
        $cancelreq -> save();

        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('leader.rfo.index',[
            'rfo' => $rfo,
        ]));

     }


     public function cancelorderbaru(Request $request){

        
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        
        $loggedInUser = auth()->user();
        
        $rfodata = RFO::find($request->rfo_id);


        if ($rfodata) {
            $rfodata->status_rfo = 'Menunggu Persetujuan Cancel'; // Ganti dengan status yang sesuai
            $rfodata->save();
        }

        $idrfo = $rfodata->id;


        $sodata = SalesOrder::where('rfo_id', $idrfo)->get();

        foreach ($sodata as $so) {
            $so->cancel_approval = "Yes";
            $so->alasan = $request->alasan;
            $so->save();
        }
 
        


        $request->session()->flash('success', "Request Cancel terkirim");
        return redirect(route('sales.rfo.index',[
            'rfo' => $rfo,
        ]));

     }

     public function tampilpesanan($id)
     {
     
        $pesanan = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $rfo = RFO::find($id);
        $norfo = $rfo->no_rfo;
       
        return view('sales.rfo.tampilpesanan',[
            'pesanan' =>$pesanan,
            'norfo' => $norfo,
        ]);

     }

     public function leadertampilpesanan($id)
     {
     
        $pesanan = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $rfo = RFO::find($id);
        $norfo = $rfo->no_rfo;
       
        return view('leader.rfo.tampilpesanan',[
            'pesanan' =>$pesanan,
            'norfo' => $norfo,
        ]);

     }

     public function managertampilpesanan($id)
     {
     
        $pesanan = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $rfo = RFO::find($id);
        $norfo = $rfo->no_rfo;
       
        return view('manager.rfo.tampilpesanan',[
            'pesanan' =>$pesanan,
            'norfo' => $norfo,
        ]);

     }

     public function admininvoicetampilpesanan($id)
     {
     
        $pesanan = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $rfo = RFO::find($id);
        $norfo = $rfo->no_rfo;
       
        return view('admininvoice.rfo.tampilpesanan',[
            'pesanan' =>$pesanan,
            'norfo' => $norfo,
        ]);

     }

     public function superadmintampilpesanan($id)
     {
     
        $pesanan = DetailRFO::with('rfo')->where('rfo_id', $id)->get();
        $rfo = RFO::find($id);
        $norfo = $rfo->no_rfo;
       
        return view('superadmin.rfo.tampilpesanan',[
            'pesanan' =>$pesanan,
            'norfo' => $norfo,
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
