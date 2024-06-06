<?php

namespace App\Http\Controllers;

use App\Models\DetailInvoice;
use App\Models\Inovice;
use Illuminate\Http\Request;

class DOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function managertampildo($id){
        $invoice = Inovice::find($id);
        $detailinvoice = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();

        return view('manager.invoice.tampildo',[
            'invoice' => $invoice,
            'detailinvoice' => $detailinvoice,
        ]);
     }
     public function tampildo($id){
        $invoice = Inovice::find($id);
        $detailinvoice = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();

        return view('admininvoice.do.tampildo',[
            'invoice' => $invoice,
            'detailinvoice' => $detailinvoice,
        ]);
     }

     public function superadmintampildo($id){
        $invoice = Inovice::find($id);
        $detailinvoice = DetailInvoice::with('invoice')->where('invoice_id', $id)->get();

        return view('superadmin.do.tampildo',[
            'invoice' => $invoice,
            'detailinvoice' => $detailinvoice,
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
