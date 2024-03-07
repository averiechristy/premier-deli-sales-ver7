<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', function () {
    return view('auth.login');
});



Route::get('superadmin/dashboard', [DashboardController::class, 'superadminindex'])->name('superadmin.dashboard');
Route::get('adminproduk/dashboard', [DashboardController::class, 'adminprodukindex'])->name('adminproduk.dashboard');
Route::get('sales/dashboard',[DashboardController::class,'salesindex'])->name('sales.dashboard');



Route::get('superadmin/useraccount/index', [UserAccountController::class, 'superadminindex'])->name('superadmin.useraccount.index');
Route::get('superadmin/useraccount/create', [UserAccountController::class, 'superadmincreate'])->name('superadmin.useraccount.create');
Route::post('superadmin/useraccount/simpan', [UserAccountController::class, 'superadminstore'])->name('superadmin.useraccount.simpan');
Route::get('/tampiluser/{id}', [UserAccountController::class, 'superadminshow'])->name('tampiluser');
Route::post('/updateuser/{id}', [UserAccountController::class, 'superadminupdate'])->name('updateuser');
Route::delete('/deleteuser/{id}', [UserAccountController::class, 'superadmindestroy'])->name('deleteuser');
Route::post('/reset-password', [UserAccountController::class,'superadminresetPassword'])->name('reset-password');


Route::get('adminproduk/produk/index',[ProdukController::class,'adminprodukindex'])->name('adminproduk.produk.index');
Route::get('/download-template', [ProdukController::class,'download'])->name('download.template');
Route::post('/import-products', [ProdukController::class,'import'])->name('import.products');
Route::get('adminproduk/produk/create',[ProdukController::class,'adminprodukcreate'])->name('adminproduk.produk.create');
Route::post('adminproduk/produk/simpan',[ProdukController::class,'adminprodukstore'])->name('adminproduk.produk.simpan');
Route::get('/tampilproduk/{id}',[ProdukController::class,'adminprodukshow'])->name('tampilproduk');
Route::post('/updateproduk/{id}',[ProdukController::class,'adminprodukupdate'])->name('updateproduk');
Route::delete('/deleteproduk/{id}',[ProdukController::class,'adminprodukdestroy'])->name('deleteproduk');
