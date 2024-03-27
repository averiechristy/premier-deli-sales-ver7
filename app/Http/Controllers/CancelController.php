<?php

namespace App\Http\Controllers;

use App\Models\CancelApproval;
use App\Models\CancelApprovalSA;
use App\Models\DetailSoPo;
use App\Models\Inovice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RFO;
use App\Models\SalesOrder;
use App\Models\User;
use Illuminate\Http\Request;

class CancelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function managerinfocancel($id){

        $datarfo = RFO::find($id);
        $datacancel = CancelApproval::where('rfo_id',$id)->first();

        return view('manager.rfo.infocancel',[
            'datarfo' => $datarfo,
            'datacancel' => $datacancel,
        ]);
    }

    public function infocancel($id){

        $datarfo = RFO::find($id);
        $datacancel = CancelApproval::where('rfo_id',$id)->first();

        return view('leader.rfo.infocancel',[
            'datarfo' => $datarfo,
            'datacancel' => $datacancel,
        ]);
    }

    public function infocancelquotation($id){

        $dataquote = Quotation::find($id);
        $datacancel = CancelApproval::where('quote_id',$id)->first();

        return view('leader.quotation.infocancel',[
            'dataquote' => $dataquote,
            'datacancel' => $datacancel,
        ]);
    }

    public function managerinfocancelquotation($id){

        $dataquote = Quotation::find($id);
        $datacancel = CancelApproval::where('quote_id',$id)->first();

        return view('manager.quotation.infocancel',[
            'dataquote' => $dataquote,
            'datacancel' => $datacancel,
        ]);
    }
    public function superadmininfocancel($id){

        $datapo = PurchaseOrder::find($id);
        $datacancel = CancelApprovalSA::where('po_id',$id)->first();
      

        return view('superadmin.po.infocancel',[
            'datapo' => $datapo,
            'datacancel' => $datacancel,
        ]);
    }

    public function managerinfocancelpo($id){

        $datapo = PurchaseOrder::find($id);
        $datacancel = CancelApprovalSA::where('po_id',$id)->first();
      

        return view('manager.infocancel',[
            'datapo' => $datapo,
            'datacancel' => $datacancel,
        ]);
    }

    public function superadmininfocancelinvoice($id){

        $datainv = Inovice::find($id);
        $datacancel = CancelApprovalSA::where('invoice_id',$id)->first();
      

        return view('superadmin.invoice.infocancel',[
            'datainv' => $datainv,
            'datacancel' => $datacancel,
        ]);
    }

    public function managerinfocancelinvoice($id){

        $datainv = Inovice::find($id);
        $datacancel = CancelApprovalSA::where('invoice_id',$id)->first();
      

        return view('manager.infocancelinvoice',[
            'datainv' => $datainv,
            'datacancel' => $datacancel,
        ]);
    }
    public function approvecancel(Request $request)
    {

$rfoid = $request -> rfo_id;

$datacancel = CancelApproval::where('rfo_id', $rfoid)->get();
$datarfo = RFO::find($rfoid);

foreach ($datacancel as $cancel) {
    $cancel->status_cancel = "Disetujui";
    $cancel->save();
}

$datarfo->status_rfo = "Cancelled";
$datarfo->save();

$dataso = SalesOrder::where('rfo_id', $rfoid)->get();

foreach ($dataso as $so) {
   $so -> status_so = "Cancelled";
   $so->save();
}


$request->session()->flash('successdua', "Pembatalan Disetujui");

return redirect()->route('leader.rfo.index');

    }

    public function managerapprovecancel(Request $request)
    {

$rfoid = $request -> rfo_id;

$datacancel = CancelApproval::where('rfo_id', $rfoid)->get();
$datarfo = RFO::find($rfoid);

foreach ($datacancel as $cancel) {
    $cancel->status_cancel = "Disetujui";
    $cancel->save();
}

$datarfo->status_rfo = "Cancelled";
$datarfo->save();

$dataso = SalesOrder::where('rfo_id', $rfoid)->get();

foreach ($dataso as $so) {
   $so -> status_so = "Cancelled";
   $so->save();
}


$request->session()->flash('successdua', "Pembatalan Disetujui");

return redirect()->route('manager.rfo.index');

    }
    public function approvecancelquote(Request $request){

        $quoteid = $request -> quote_id;
        
        $datacancel = CancelApproval::where('quote_id', $quoteid)->get();
     
        
        foreach ($datacancel as $cancel) {
            $cancel->status_cancel = "Disetujui";
            $cancel->save();
        }
        $dataquote = Quotation::find($quoteid);

        $dataquote->status_quote = "Cancelled";
        $dataquote->save();
        
      
        
        $request->session()->flash('successdua', "Pembatalan Disetujui");
        
        return redirect()->route('leader.quotation.index');
        
            }

            public function managerapprovecancelquote(Request $request){

                $quoteid = $request -> quote_id;
                
                $datacancel = CancelApproval::where('quote_id', $quoteid)->get();
             
                
                foreach ($datacancel as $cancel) {
                    $cancel->status_cancel = "Disetujui";
                    $cancel->save();
                }
                $dataquote = Quotation::find($quoteid);
        
                $dataquote->status_quote = "Cancelled";
                $dataquote->save();
                
              
                
                $request->session()->flash('successdua', "Pembatalan Disetujui");
                
                return redirect()->route('manager.quotation.index');
                
                    }
    public function superadminapprovecancel(Request $request){

      

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

        $datacancel = CancelApprovalSA::where('po_id', $poid)->get();


foreach ($datacancel as $cancel) {
    $cancel->status_cancel = "Disetujui";
    $cancel->save();
}

        $podata = PurchaseOrder::find($poid);
        $podata -> status_po = "Cancelled";
        $podata -> save();

        $request->session()->flash('success', "Pembatalan Disetujui");
        
        return redirect()->route('superadmin.po.index');
        
            }

            public function managerapprovecancelpo(Request $request){

      

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

                $datacancel = CancelApprovalSA::where('po_id', $poid)->get();
            
        foreach ($datacancel as $cancel) 
        {
                $cancel->status_cancel = "Disetujui";
                $cancel->save();
            }
        
                $podata = PurchaseOrder::find($poid);
                $podata -> status_po = "Cancelled";
                $podata -> save();
        
                $request->session()->flash('success', "Pembatalan Disetujui");
                
                return redirect()->route('managerapproval');
                
                    }
        
            public function superadminapprovecancelinvoice(Request $request){

                $invid = $request -> invoice_id;
                
                $datacancel = CancelApprovalSA::where('invoice_id', $invid)->get();
                $datainvoice = Inovice::find($invid);
                
                foreach ($datacancel as $cancel) {
                    $cancel->status_cancel = "Disetujui";
                    $cancel->save();
                }
                
                $datainvoice->status_invoice = "Cancelled";
                $datainvoice->save();

                $soid = $datainvoice->so_id;
                
                $dataso = SalesOrder::where('id', $soid)->get();
                
              
                foreach ($dataso as $so) {
                   $so -> status_so = "Cancelled";
                   $so->save();
                }
                
                
                $request->session()->flash('success', "Pembatalan Disetujui");
                
                return redirect()->route('superadmin.invoice.index');
                
                    }

                    public function managerapprovecancelinvoice(Request $request){

                        $invid = $request -> invoice_id;
                        
                        $datacancel = CancelApprovalSA::where('invoice_id', $invid)->get();
                        $datainvoice = Inovice::find($invid);
                        
                        foreach ($datacancel as $cancel) {
                            $cancel->status_cancel = "Disetujui";
                            $cancel->save();
                        }
                        
                        $datainvoice->status_invoice = "Cancelled";
                        $datainvoice->save();
        
                        $soid = $datainvoice->so_id;
                        
                        $dataso = SalesOrder::where('id', $soid)->get();
                        
                      
                        foreach ($dataso as $so) {
                           $so -> status_so = "Cancelled";
                           $so->save();
                        }
                        
                        
                        $request->session()->flash('success', "Pembatalan Disetujui");
                        
                        return redirect()->route('managerapproval');
                        
                            }
    /**
     * Show the form for creating a new resource.
     */
    public function managerapprovalindex(){
      
        $loggedInUser = auth()->user();
        $userid = $loggedInUser ->id;
        
        $datapo = CancelApprovalSA::where('report_to', $userid)->get();

        $poids = $datapo->pluck('po_id')->toArray();
    
        // Mengambil semua data PurchaseOrder berdasarkan po_id yang ditemukan
        $purchaseOrders = PurchaseOrder::whereIn('id', $poids)->get();
        

        $datainv = CancelApprovalSA::where('report_to', $userid)->get();

        $invids = $datainv->pluck('invoice_id')->toArray();
    
        // Mengambil semua data PurchaseOrder berdasarkan po_id yang ditemukan
        $invoice = Inovice::whereIn('id', $invids)->get();

  

        return view('manager.approval',[
         'purchaseOrders' => $purchaseOrders,
         'invoice' => $invoice,
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
