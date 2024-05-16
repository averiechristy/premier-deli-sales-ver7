<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function admininvoicechangepasswordindex()
    {
        return view('admininvoice.changepassword');
    }

    public function admininvoicechangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('password')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('password');
        }
    }

    public function adminprodukchangepasswordindex()
    {
        return view('adminproduk.changepassword');
    }

    public function adminprodukchangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('adminprodukpassword')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('adminprodukpassword');
        }
    }

    public function superadminchangepasswordindex()
    {
        return view('superadmin.changepassword');
    }

    public function superadminchangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('superadminpassword')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('superadminpassword');
        }
    }

    public function saleschangepasswordindex()
    {
        return view('sales.changepassword');
    }

    public function saleschangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('salespassword')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('salespassword');
        }
    }

    public function leaderchangepasswordindex()
    {
        return view('leader.changepassword');
    }

    public function leaderchangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('leaderpassword')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('leaderpassword');
        }
    }
    public function managerchangepasswordindex()
    {
        return view('manager.changepassword');
    }

    public function managerchangepassword(Request $request)
    {
     
        $password = auth()->user()->password;
       
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('managerpassword')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('managerpassword');
        }
    }
    public function superadminindex(){
        $User = User::orderBy('created_at', 'desc')->get();
        return view ('superadmin.useraccount.index',[
            'User' => $User,
        ]);
    }


    public function superadmincreate(){

        $role = UserRole::all();
        $user = User::where('role_id', 4)->get();

        $manager = User::where('role_id', 6)->get();
        return view('superadmin.useraccount.create',[
           'role' => $role,
           'user' => $user,
           'manager' => $manager,
        ]);
    }
    public function resetPassword(User $user, Request $request)
    {
        $user->update([
            'password' => Hash::make('12345678'), // Ganti 'password_awal' dengan password yang Anda inginkan
        ]);
    
        $request->session()->flash('success', 'Password berhasil direset');
    
        return redirect()->route('superadmin.useraccount.index');
    }
    public function superadminstore(Request $request){

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 
        $roleid = $request->role_id;
        $namauser = $request->nama_user;
        $username = $request->username;
        $email = $request->email;
        $reportto = $request -> selected_user;
    
   
        $existingdata = User::where('email', $email)->first();
        if($existingdata){
            $request->session()->flash('error', 'Data gagal disimpan, email sudah terdaftar');

            return redirect(route('superadmin.useraccount.index'));
    
        }

       

        User::create([
            'role_id' => $roleid,
            'nama' => $namauser,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make('12345678'),
            'no_hp' => $request->no_hp,
            'report_to' => $reportto,
            'created_by' => $loggedInUsername,
        ]);

        $request->session()->flash('success', 'Akun User berhasil ditambahkan');

        return redirect(route('superadmin.useraccount.index'));

    }

    public function superadminshow($id){
        $data = User::find($id);
        $role = UserRole::all();
        $user = User::where('role_id', 4)->get();
        $manager = User::where('role_id', 6)->get();

       
        return view ('superadmin.useraccount.edit',[
            'data' => $data,
            'role' => $role,
            'user' => $user,
            'manager' => $manager,
        ]);

    }

    public function superadminupdate(Request $request, $id){

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama; 

        if($request->role_id =='5'){
            $data = User::find($id);
       
            $data->role_id = $request->role_id;
            $data->nama = $request->nama_user;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->no_hp = $request->no_hp;
            $data -> report_to = $request -> selected_user;
            $data->updated_by = $loggedInUsername;
    
            $data->save();
        }
        else if($request->role_id =='4'){
            $data = User::find($id);
       
            $data->role_id = $request->role_id;
            $data->nama = $request->nama_user;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->no_hp = $request->no_hp;
            $data -> report_to = $request -> selected_user;
            $data->updated_by = $loggedInUsername;
            $data->save();
        }

       else if($request->role_id =='2'){
            $data = User::find($id);
       
            $data->role_id = $request->role_id;
            $data->nama = $request->nama_user;
            $data->username = $request->username;
            $data->email = $request->email;
            $data->no_hp = $request->no_hp;
            $data -> report_to = $request -> selected_user;
            $data->updated_by = $loggedInUsername;
            $data->save();
        }
        else {
            
        
        $data = User::find($id);
       
        $data->role_id = $request->role_id;
        $data->nama = $request->nama_user;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->no_hp = $request->no_hp;
        $data->updated_by = $loggedInUsername;
        $data->save();
    }

        $request->session()->flash('success', "Akun User berhasil diubah");
    
        return redirect(route('superadmin.useraccount.index'));

    }

    public function superadmindestroy(Request $request, $id){
        $useraccount = User::find($id);

        if ($useraccount->Role->jenis_role === 'Super Admin') {
            if ($useraccount->id === Auth::id()) {
                return redirect()->route('superadmin.useraccount.index')->with('error', 'Tidak dapat menghapus akun anda sendiri.');
            }

            $superadminakun = User::whereHas('Role', function ($query) {
                $query->where('jenis_role', 'Super Admin');
            })->count();

            if ($superadminakun <= 1) {
                return redirect()->route('superadmin.useraccount.index')->with('error', 'Tidak dapat menghapus akun superadmin terakhir.');
            }
        }

        if (User::where('report_to', $useraccount->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus user, karena masih ada data report yang berhubungan");
            return redirect()->route('superadmin.useraccount.index');
        }

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
