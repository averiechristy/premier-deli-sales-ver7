<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */



     public function managerindex()
     {
        $kategori = Kategori::orderBy('created_at', 'desc')->get();

        return view('manager.kategori.index',[
            'kategori' => $kategori,
        ]);
     }

     public function managercreate()
     {
        return view('manager.kategori.create');
     }

     public function managerstore(Request $request)
     {
        
        $kategori = $request -> kategori;
        $existingname = Kategori::where('kategori',$kategori)->first();

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama;  
       
        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Kategori sudah terdaftar.");
            return redirect()->route('manager.kategori.index');
        }

        Kategori::create([
            'kategori' => $kategori,
            'created_by' => $loggedInUsername,
           
          ]);

          $request->session()->flash('success', "Kategori berhasil ditambahkan.");

          return redirect()->route('manager.kategori.index');

     }

     public function managershow($id){

        $data = Kategori::find($id);

        return view('manager.kategori.edit',[
            'data' => $data,
        ]);

     }

     public function managerupdate(Request $request, $id)
     {
        $kategori = $request -> kategori;

        $existingname = Kategori::where('kategori',$kategori)
        ->where('id', '!=', $id)
        ->first();

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        if($existingname !== null && $existingname) {
            $request->session()->flash('error', "Kategori sudah terdaftar.");
            return redirect()->route('manager.kategori.index');
        }

        $data = Kategori::find($id);
        $data -> kategori = $kategori;
        $data->updated_by = $loggedInUsername;
        $data -> save();

        $request->session()->flash('success', "Kategori berhasil diubah.");

        return redirect()->route('manager.kategori.index');
     }

     
     public function managerdestroy(Request $request, $id){

        $kategori = Kategori::find($id);

        if (Customer::where('kategori_id', $kategori->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus kategori, karena masih ada data customer yang berhubungan.");
            return redirect()->route('manager.kategori.index');
        }
     

        $kategori->delete();
        
        $request->session()->flash('success', "Kategori berhasil dihapus.");
        
        return redirect()->route('manager.kategori.index');
    }


    // LEADER 

    public function leaderindex()
    {
       $kategori = Kategori::orderBy('created_at', 'desc')->get();

       return view('leader.kategori.index',[
           'kategori' => $kategori,
       ]);
    }

    public function leadercreate()
    {
       return view('leader.kategori.create');
    }

    public function leaderstore(Request $request)
    {
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
       $kategori = $request -> kategori;
       $existingname = Kategori::where('kategori',$kategori)->first();
      
       if($existingname !== null && $existingname) {
           $request->session()->flash('error', "Kategori sudah terdaftar.");
           return redirect()->route('leader.kategori.index');
       }

       Kategori::create([
           'kategori' => $kategori,
           'created_by' => $loggedInUsername,
          
         ]);

         $request->session()->flash('success', "Kategori berhasil ditambahkan.");

         return redirect()->route('leader.kategori.index');

    }

    public function leadershow($id){

       $data = Kategori::find($id);

       return view('leader.kategori.edit',[
           'data' => $data,
       ]);

    }

    public function leaderupdate(Request $request, $id)
    {
       $kategori = $request -> kategori;
       $loggedInUser = auth()->user();
       $loggedInUsername = $loggedInUser->nama; 

       $existingname = Kategori::where('kategori',$kategori)
       ->where('id', '!=', $id)
       ->first();

       if($existingname !== null && $existingname) {
           $request->session()->flash('error', "Kategori sudah terdaftar.");
           return redirect()->route('leader.kategori.index');
       }

       $data = Kategori::find($id);
       $data -> kategori = $kategori;
       $data -> updated_by = $loggedInUsername;
       $data -> save();

       $request->session()->flash('success', "Kategori berhasil diubah.");

       return redirect()->route('leader.kategori.index');
    }

    
    public function leaderdestroy(Request $request, $id){

       $kategori = Kategori::find($id);

       if (Customer::where('kategori_id', $kategori->id)->exists()) {
           $request->session()->flash('error', "Tidak dapat menghapus kategori, karena masih ada data customer yang berhubungan.");
           return redirect()->route('leader.kategori.index');
       }
    

       $kategori->delete();
       
       $request->session()->flash('success', "Kategori berhasil dihapus.");
       
       return redirect()->route('leader.kategori.index');
   }


//    SUPERADMINN


public function superadminindex()
{
   $kategori = Kategori::orderBy('created_at', 'desc')->get();

   return view('superadmin.kategori.index',[
       'kategori' => $kategori,
   ]);
}

public function superadmincreate()
{
   return view('superadmin.kategori.create');
}

public function superadminstore(Request $request)
{
 
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
   $kategori = $request -> kategori;
   $existingname = Kategori::where('kategori',$kategori)->first();
  
   if($existingname !== null && $existingname) {
       $request->session()->flash('error', "Kategori sudah terdaftar.");
       return redirect()->route('superadmin.kategori.index');
   }

   Kategori::create([
       'kategori' => $kategori,
       'created_by' => $loggedInUsername,
      
     ]);

     $request->session()->flash('success', "Kategori berhasil ditambahkan.");

     return redirect()->route('superadmin.kategori.index');

}

public function superadminshow($id){

   $data = Kategori::find($id);

   return view('superadmin.kategori.edit',[
       'data' => $data,
   ]);

}

public function superadminupdate(Request $request, $id)
{
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama; 
   $kategori = $request -> kategori;

   $existingname = Kategori::where('kategori',$kategori)
   ->where('id', '!=', $id)
   ->first();

   if($existingname !== null && $existingname) {
       $request->session()->flash('error', "Kategori sudah terdaftar.");
       return redirect()->route('superadmin.kategori.index');
   }

   $data = Kategori::find($id);
   $data -> kategori = $kategori;
   $data -> updated_by = $loggedInUsername;
   $data -> save();

   $request->session()->flash('success', "Kategori berhasil diubah.");

   return redirect()->route('superadmin.kategori.index');
}


public function superadmindestroy(Request $request, $id){

   $kategori = Kategori::find($id);

   if (Customer::where('kategori_id', $kategori->id)->exists()) {
       $request->session()->flash('error', "Tidak dapat menghapus kategori, karena masih ada data customer yang berhubungan.");
       return redirect()->route('superadmin.kategori.index');
   }


   $kategori->delete();
   
   $request->session()->flash('success', "Kategori berhasil dihapus.");
   
   return redirect()->route('superadmin.kategori.index');
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
