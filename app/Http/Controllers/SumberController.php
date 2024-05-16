<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sumber;
use Illuminate\Http\Request;

class SumberController extends Controller
{
    /**
     * Display a listing of the resource.
     */


     public function managerindex()
     {
        $sumber = Sumber::orderBy('created_at', 'desc')->get();
        return view('manager.sumber.index',[
            'sumber' => $sumber,
        ]);
     }

     public function managercreate()
     {
        return view('manager.sumber.create');
     }

     public function managerstore(Request $request)
     {
        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $sumber = $request -> sumber;
        $existingname = Sumber::where('sumber',$sumber)->first();
       
        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
            return redirect()->route('manager.sumber.index');
        }

        Sumber::create([
            'sumber' => $sumber,
            'created_by' => $loggedInUsername
           
          ]);

          $request->session()->flash('success', "Data sumber berhasil ditambahkan.");

          return redirect()->route('manager.sumber.index');

     }

     public function managershow($id)
     {
        $data = Sumber::find($id);

        return view('manager.sumber.edit',[
            'data' => $data,
        ]);
     }


     public function managerupdate(Request $request, $id)
     {
      
        $sumber = $request ->sumber;


        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $existingname = Sumber::where('sumber',$sumber)
        ->where('id', '!=', $id)
        ->first();

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
            return redirect()->route('manager.sumber.index');
        }

        $data = Sumber::find($id);
        $data -> sumber = $sumber;
        $data->updated_by = $loggedInUsername;
        $data -> save();


  $request->session()->flash('success', "Data sumber berhasil diubah.");

        return redirect()->route('manager.sumber.index');
     }

     public function managerdestroy(Request $request, $id){

        $sumber = Sumber::find($id);
 
        if (Customer::where('sumber_id', $sumber->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus sumber, karena masih ada data customer yang berhubungan.");
            return redirect()->route('manager.sumber.index');
        }
     
 
        $sumber->delete();
        
        $request->session()->flash('success', "Sumber berhasil dihapus.");
        
        return redirect()->route('manager.sumber.index');
    }

    // LEADER


    public function leaderindex()
    {
       $sumber = Sumber::orderBy('created_at', 'desc')->get();
       return view('leader.sumber.index',[
           'sumber' => $sumber,
       ]);
    }

    public function leadercreate()
    {
       return view('leader.sumber.create');
    }

    public function leaderstore(Request $request)
    {
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
       $sumber = $request -> sumber;
       $existingname = Sumber::where('sumber',$sumber)->first();
      
       if($existingname !== null && $existingname) {
           $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
           return redirect()->route('leader.sumber.index');
       }

       Sumber::create([
           'sumber' => $sumber,
           'created_by' => $loggedInUsername,
          
         ]);

         $request->session()->flash('success', "Data sumber berhasil ditambahkan.");

         return redirect()->route('leader.sumber.index');

    }

    public function leadershow($id)
    {
       $data = Sumber::find($id);

       return view('leader.sumber.edit',[
           'data' => $data,
       ]);
    }


    public function leaderupdate(Request $request, $id)
    {
     
       $sumber = $request ->sumber;


       $loggedInUser = auth()->user();
       $loggedInUsername = $loggedInUser->nama; 
       $existingname = Sumber::where('sumber',$sumber)
       ->where('id', '!=', $id)
       ->first();

       if($existingname !== null && $existingname) {
           $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
           return redirect()->route('leader.sumber.index');
       }

       $data = Sumber::find($id);
       $data -> sumber = $sumber;
       $data -> updated_by = $loggedInUsername;
       $data -> save();


 $request->session()->flash('success', "Data sumber berhasil diubah.");

       return redirect()->route('leader.sumber.index');
    }

    public function leaderdestroy(Request $request, $id){

       $sumber = Sumber::find($id);

       if (Customer::where('sumber_id', $sumber->id)->exists()) {
           $request->session()->flash('error', "Tidak dapat menghapus sumber, karena masih ada data customer yang berhubungan.");
           return redirect()->route('leader.sumber.index');
       }
    

       $sumber->delete();
       
       $request->session()->flash('success', "Sumber berhasil dihapus.");
       
       return redirect()->route('leader.sumber.index');
   }

// SUPERADMINNN


public function superadminindex()
{
   $sumber = Sumber::orderBy('created_at', 'desc')->get();
   return view('superadmin.sumber.index',[
       'sumber' => $sumber,
   ]);
}

public function superadmincreate()
{
   return view('superadmin.sumber.create');
}

public function superadminstore(Request $request)
{
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
   $sumber = $request -> sumber;
   $existingname = Sumber::where('sumber',$sumber)->first();
  
   if($existingname !== null && $existingname) {
       $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
       return redirect()->route('superadmin.sumber.index');
   }

   Sumber::create([
       'sumber' => $sumber,
       'created_by' => $loggedInUsername,
      
     ]);

     $request->session()->flash('success', "Data sumber berhasil ditambahkan.");

     return redirect()->route('superadmin.sumber.index');

}

public function superadminshow($id)
{
   $data = Sumber::find($id);

   return view('superadmin.sumber.edit',[
       'data' => $data,
   ]);
}


public function superadminupdate(Request $request, $id)
{
 
   $sumber = $request ->sumber;

   $loggedInUser = auth()->user();
   $loggedInUsername = $loggedInUser->nama; 

   $existingname = Sumber::where('sumber',$sumber)
   ->where('id', '!=', $id)
   ->first();

   if($existingname !== null && $existingname) {
       $request->session()->flash('error', "Data gagal disimpan, sumber sudah ada");
       return redirect()->route('superadmin.sumber.index');
   }

   $data = Sumber::find($id);
   $data -> sumber = $sumber;
   $data->updated_by = $loggedInUsername;
   $data -> save();


$request->session()->flash('success', "Data sumber berhasil diubah.");

   return redirect()->route('superadmin.sumber.index');
}

public function superadmindestroy(Request $request, $id){

   $sumber = Sumber::find($id);

   if (Customer::where('sumber_id', $sumber->id)->exists()) {
       $request->session()->flash('error', "Tidak dapat menghapus sumber, karena masih ada data customer yang berhubungan.");
       return redirect()->route('superadmin.sumber.index');
   }


   $sumber->delete();
   
   $request->session()->flash('success', "Sumber berhasil dihapus.");
   
   return redirect()->route('superadmin.sumber.index');
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
