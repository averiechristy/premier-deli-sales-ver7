<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function superadminindex(){
        $catatan = Catatan::orderBy('created_at', 'desc')->get();
      return view('superadmin.catatan.index',[
        'catatan' => $catatan,
      ]);
     }

     public function superadmincreate(){
        return view ('superadmin.catatan.create');
     }

     public function superadminstore(Request $request){
       
        $judul = $request -> judul_catatan;
        $isi = $request -> isi_catatan;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $existingdata = Catatan::where('judul_catatan', $judul)->first();

        if($existingdata){
            $request->session()->flash('error', "Catatan sudah terdaftar.");
    
            return redirect()->route('superadmin.catatan.index');
        }

        Catatan::create([
            'judul_catatan' => $judul,
            'isi_catatan' => $isi,
            'created_by' => $loggedInUsername,
         ]);

         
        $request->session()->flash('success', 'Catatan quotation berhasil ditambahkan.');

        return redirect(route('superadmin.catatan.index'));
     }

     public function superadminshow( $id){

        $data = Catatan::find($id);

        return view('superadmin.catatan.edit',[
            'data' => $data,
        ]);

     }

     public function superadminupdate(Request $request, $id){
        $data = Catatan::find($id);

$judul = $request->judul_catatan;;
        
        $data->judul_catatan = $request->judul_catatan;
        $data->isi_catatan = $request->isi_catatan;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $data-> updated_by = $loggedInUsername;
        $existingname = Catatan::where('judul_catatan',$judul)
        ->where('id', '!=', $id)
        ->first();

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Data gagal disimpan, judul catatan sudah ada");
            return redirect()->route('superadmin.catatan.index');
        }
        $data->save();

        $request->session()->flash('success', 'Catatan quotation berhasil diubah.');

        return redirect(route('superadmin.catatan.index'));
     }


     public function superadmindestroy($id, Request $request){

        $catatan = Catatan::find($id);
        $catatan->delete();

        $request->session()->flash('success', "Catatan quotation berhasil dihapus.");
   
        return redirect()->route('superadmin.catatan.index');
     }
     





          public function admininvoiceindex(){
        $catatan = Catatan::orderBy('created_at', 'desc')->get();
      return view('admininvoice.catatan.index',[
        'catatan' => $catatan,
      ]);
     }

     public function admininvoicecreate(){
        return view ('admininvoice.catatan.create');
     }

     public function admininvoicestore(Request $request){
       
        $judul = $request -> judul_catatan;
        $isi = $request -> isi_catatan;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $existingdata = Catatan::where('judul_catatan', $judul)->first();

        if($existingdata){
            $request->session()->flash('error', "Catatan sudah terdaftar.");
    
            return redirect()->route('admininvoice.catatan.index');
        }

        Catatan::create([
            'judul_catatan' => $judul,
            'isi_catatan' => $isi,
            'created_by' => $loggedInUsername,
         ]);

         
        $request->session()->flash('success', 'Catatan quotation berhasil ditambahkan.');

        return redirect(route('admininvoice.catatan.index'));
     }

     public function admininvoiceshow( $id){

        $data = Catatan::find($id);

        return view('admininvoice.catatan.edit',[
            'data' => $data,
        ]);

     }

     public function admininvoiceupdate(Request $request, $id){
        $data = Catatan::find($id);

$judul = $request->judul_catatan;;
        
        $data->judul_catatan = $request->judul_catatan;
        $data->isi_catatan = $request->isi_catatan;
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $data->updated_by = $loggedInUsername;

        $existingname = Catatan::where('judul_catatan',$judul)
        ->where('id', '!=', $id)
        ->first();

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Data gagal disimpan, judul catatan sudah ada");
            return redirect()->route('admininvoice.catatan.index');
        }
        $data->save();

        $request->session()->flash('success', 'Catatan quotation berhasil diubah.');

        return redirect(route('admininvoice.catatan.index'));
     }


     public function admininvoicedestroy($id, Request $request){

        $catatan = Catatan::find($id);
        $catatan->delete();

        $request->session()->flash('success', "Catatan quotation berhasil dihapus.");
   
        return redirect()->route('admininvoice.catatan.index');
     }






     public function managerindex(){
        $catatan = Catatan::orderBy('created_at', 'desc')->get();
      return view('manager.catatan.index',[
        'catatan' => $catatan,
      ]);
     }

     public function managercreate(){
        return view ('manager.catatan.create');
     }

     public function managerstore(Request $request){
       
        $judul = $request -> judul_catatan;
        $isi = $request -> isi_catatan;

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $existingdata = Catatan::where('judul_catatan', $judul)->first();

        if($existingdata){
            $request->session()->flash('error', "Catatan sudah terdaftar.");
    
            return redirect()->route('manager.catatan.index');
        }

        Catatan::create([
            'judul_catatan' => $judul,
            'isi_catatan' => $isi,
            'created_by' => $loggedInUsername,
         ]);

         
        $request->session()->flash('success', 'Catatan quotation berhasil ditambahkan.');

        return redirect(route('manager.catatan.index'));
     }

     public function managershow( $id){

        $data = Catatan::find($id);

        return view('manager.catatan.edit',[
            'data' => $data,
        ]);

     }

     public function managerupdate(Request $request, $id){
        $data = Catatan::find($id);

$judul = $request->judul_catatan;;
        
        $data->judul_catatan = $request->judul_catatan;
        $data->isi_catatan = $request->isi_catatan;
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        $existingname = Catatan::where('judul_catatan',$judul)
        ->where('id', '!=', $id)
        ->first();

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Data gagal disimpan, judul catatan sudah ada");
            return redirect()->route('manager.catatan.index');
        }

        $data->updated_by = $loggedInUsername;
        $data->save();

        $request->session()->flash('success', 'Catatan quotation berhasil diubah.');

        return redirect(route('manager.catatan.index'));
     }


     public function managerdestroy($id, Request $request){

        $catatan = Catatan::find($id);
        $catatan->delete();

        $request->session()->flash('success', "Catatan quotation berhasil dihapus.");
   
        return redirect()->route('manager.catatan.index');
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
