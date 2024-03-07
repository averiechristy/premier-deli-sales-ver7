<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function superadminindex(){
        $User = User::orderBy('created_at', 'desc')->get();
        return view ('superadmin.useraccount.index',[
            'User' => $User,
        ]);
    }


    public function superadmincreate(){

        $role = UserRole::all();
    
        return view('superadmin.useraccount.create',[
           'role' => $role,
        ]);
    }

    public function superadminstore(Request $request){
      
        $roleid = $request->role_id;
        $namauser = $request->nama_user;
        $username = $request->username;
        $email = $request->email;
        $password = $request->password; // Ambil password dari inputan form

        // Buat hash dari password
        $password_hashed = password_hash($password, PASSWORD_DEFAULT);
       
        User::create([
            'role_id' => $roleid,
            'nama' => $namauser,
            'username' => $username,
            'email' => $email,
            'password' => $password_hashed,
        ]);

        $request->session()->flash('success', 'Akun User berhasil ditambahkan');

        return redirect(route('superadmin.useraccount.index'));

    }

    public function superadminshow($id){
        $data = User::find($id);
        $role = UserRole::all();

       
        return view ('superadmin.useraccount.edit',[
            'data' => $data,
            'role' => $role,
        ]);

    }

    public function superadminupdate(Request $request, $id){

        $data = User::find($id);
       
        $data->role_id = $request->role_id;
        $data->nama = $request->nama_user;
        $data->username = $request->username;
        $data->email = $request->email;

        $data->save();

        $request->session()->flash('success', "Akun User berhasil diupdate");
    
        return redirect(route('superadmin.useraccount.index'));

    }

    public function superadmindestroy(Request $request, $id){
        $useraccount = User::find($id);
        $useraccount->delete();

        $request->session()->flash('success', "Akun User berhasil dihapus");

        return redirect()->route('superadmin.useraccount.index');
    }

    public function adminprodukindex(){
        
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
