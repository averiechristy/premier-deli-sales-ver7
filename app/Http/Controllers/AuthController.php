<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('auth.login');
    }
   
   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->only('email', 'password');
        
        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Authentication passed...

           

            // Check user role and redirect accordingly
            $user = Auth::user();


            if ($user->isSuperAdmin()) {
                return redirect()->route('superadmin.dashboard'); // Adjust the route accordingly
            } elseif ($user->isAdminInvoice()) {
                return redirect()->route('admininvoice.dashboard'); // Adjust the route accordingly
            }
            elseif ($user->isAdminProduk()) {
                return redirect()->route('adminproduk.dashboard'); // Adjust the route accordingly
            }
            elseif ($user->isSales()) {
                return redirect()->route('sales.dashboard'); // Adjust the route accordingly
            }
            elseif ($user->isLeader()) {
                return redirect()->route('leader.dashboard'); // Adjust the route accordingly
            }

        }
        // Authentication failed, redirect back with errors
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
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
