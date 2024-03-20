<?php

namespace App\Http\Controllers;

use App\Models\Inovice;
use App\Models\PurchaseOrder;
use App\Models\Quotation;
use App\Models\RFO;
use App\Models\SalesOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function superadminindex()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    
        // Mengambil data Sales Order untuk bulan berjalan
        $so = SalesOrder::whereNotIn('status_so', ['Cancelled'])
                        ->whereBetween('so_date', [$startDate, $endDate])
                        ->get();
    
        // Mengambil data Purchase Order untuk bulan berjalan
        $po = PurchaseOrder::whereNotIn('status_po', ['Cancelled'])
                            ->whereBetween('po_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Invoice untuk bulan berjalan
        $invoice = Inovice::whereNotIn('status_invoice', ['Cancelled'])
                            ->whereBetween('invoice_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Quotation untuk bulan berjalan
        $quote = Quotation::whereNotIn('status_quote', ['Cancelled'])
                            ->whereBetween('quote_date', [$startDate, $endDate])
                            ->get();
    
        return view('superadmin.dashboard', [
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
        ]);
    }

    public function adminprodukindex()
    {
        return view ('adminproduk.dashboard');
    }

    public function salesindex()
    {
        $rfo = RFO::orderBy('created_at', 'desc')->get();
        
        return view ('sales.dashboard',[
            'rfo' => $rfo,
        ]);
    }

    public function leaderindex()
    {
        return view('leader.dashboard');
    }

    public function managerindex()
    {
        return view('manager.dashboard');
    }

    public function admininvoiceindex()
    {
        // Mendapatkan tanggal awal dan akhir bulan berjalan
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    
        // Mengambil data Sales Order untuk bulan berjalan
        $so = SalesOrder::whereNotIn('status_so', ['Cancelled'])
                        ->whereBetween('so_date', [$startDate, $endDate])
                        ->get();
    
        // Mengambil data Purchase Order untuk bulan berjalan
        $po = PurchaseOrder::whereNotIn('status_po', ['Cancelled'])
                            ->whereBetween('po_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Invoice untuk bulan berjalan
        $invoice = Inovice::whereNotIn('status_invoice', ['Cancelled'])
                            ->whereBetween('invoice_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Quotation untuk bulan berjalan
        $quote = Quotation::whereNotIn('status_quote', ['Cancelled'])
                            ->whereBetween('quote_date', [$startDate, $endDate])
                            ->get();
    
        return view('admininvoice.dashboard', [
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
        ]);
    }

    public function managerdashboarddata()
    {
        // Mendapatkan tanggal awal dan akhir bulan berjalan
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
    
        // Mengambil data Sales Order untuk bulan berjalan
        $so = SalesOrder::whereNotIn('status_so', ['Cancelled'])
                        ->whereBetween('so_date', [$startDate, $endDate])
                        ->get();
    
        // Mengambil data Purchase Order untuk bulan berjalan
        $po = PurchaseOrder::whereNotIn('status_po', ['Cancelled'])
                            ->whereBetween('po_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Invoice untuk bulan berjalan
        $invoice = Inovice::whereNotIn('status_invoice', ['Cancelled'])
                            ->whereBetween('invoice_date', [$startDate, $endDate])
                            ->get();
    
        // Mengambil data Quotation untuk bulan berjalan
        $quote = Quotation::whereNotIn('status_quote', ['Cancelled'])
                            ->whereBetween('quote_date', [$startDate, $endDate])
                            ->get();
    
        return view('manager.dashboarddata', [
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
        ]);
    }
   
    public function filter(Request $request)
    {
        $bulan = $request->input('bulan');
    
        // Filter data Sales Order berdasarkan bulan
        $so = SalesOrder::whereMonth('so_date', $bulan)->whereNotIn('status_so', ['Cancelled'])->get();
    
        // Filter data Quote berdasarkan bulan
        $quote = Quotation::whereMonth('quote_date', $bulan)->whereNotIn('status_quote', ['Cancelled'])->get();
    
        // Filter data Purchase Order berdasarkan bulan
        $po = PurchaseOrder::whereMonth('po_date', $bulan)->whereNotIn('status_po', ['Cancelled'])->get();
    
        // Filter data Invoice berdasarkan bulan
        $invoice = Inovice::whereMonth('invoice_date', $bulan)->whereNotIn('status_invoice', ['Cancelled'])->get();
    
        return view ('admininvoice.dashboard',[
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
            'bulan' => $bulan,
        ]);
    }

    public function superadminfilter(Request $request)
    {
        $bulan = $request->input('bulan');
    
        // Filter data Sales Order berdasarkan bulan
        $so = SalesOrder::whereMonth('so_date', $bulan)->whereNotIn('status_so', ['Cancelled'])->get();
    
        // Filter data Quote berdasarkan bulan
        $quote = Quotation::whereMonth('quote_date', $bulan)->whereNotIn('status_quote', ['Cancelled'])->get();
    
        // Filter data Purchase Order berdasarkan bulan
        $po = PurchaseOrder::whereMonth('po_date', $bulan)->whereNotIn('status_po', ['Cancelled'])->get();
    
        // Filter data Invoice berdasarkan bulan
        $invoice = Inovice::whereMonth('invoice_date', $bulan)->whereNotIn('status_invoice', ['Cancelled'])->get();
    
        return view ('superadmin.dashboard',[
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
            'bulan' => $bulan,
        ]);
    }

    public function managerfilter(Request $request)
    {
        $bulan = $request->input('bulan');
    
        // Filter data Sales Order berdasarkan bulan
        $so = SalesOrder::whereMonth('so_date', $bulan)->whereNotIn('status_so', ['Cancelled'])->get();
    
        // Filter data Quote berdasarkan bulan
        $quote = Quotation::whereMonth('quote_date', $bulan)->whereNotIn('status_quote', ['Cancelled'])->get();
    
        // Filter data Purchase Order berdasarkan bulan
        $po = PurchaseOrder::whereMonth('po_date', $bulan)->whereNotIn('status_po', ['Cancelled'])->get();
    
        // Filter data Invoice berdasarkan bulan
        $invoice = Inovice::whereMonth('invoice_date', $bulan)->whereNotIn('status_invoice', ['Cancelled'])->get();
    
        return view ('manager.dashboarddata',[
            'so' => $so,
            'po' => $po,
            'invoice' => $invoice,
            'quote' => $quote,
            'bulan' => $bulan,
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
