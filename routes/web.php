<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DOController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RFOController;
use App\Http\Controllers\SOController;
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



Route::get('/login', [AuthController::class,'index'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

//All Dashboard
//Superadmin
Route::middleware('auth')->middleware('ensureUserRole:SUPER ADMIN')->group(function () {

Route::get('superadmin/dashboard', [DashboardController::class, 'superadminindex'])->name('superadmin.dashboard');
Route::get('superadmin/useraccount/index', [UserAccountController::class, 'superadminindex'])->name('superadmin.useraccount.index');
Route::get('superadmin/useraccount/create', [UserAccountController::class, 'superadmincreate'])->name('superadmin.useraccount.create');
Route::post('superadmin/useraccount/simpan', [UserAccountController::class, 'superadminstore'])->name('superadmin.useraccount.simpan');
Route::get('/tampiluser/{id}', [UserAccountController::class, 'superadminshow'])->name('tampiluser');
Route::post('/updateuser/{id}', [UserAccountController::class, 'superadminupdate'])->name('updateuser');
Route::delete('/deleteuser/{id}', [UserAccountController::class, 'superadmindestroy'])->name('deleteuser');
Route::post('/reset-password', [UserAccountController::class,'superadminresetPassword'])->name('reset-password');


});

//Admin Produk
Route::middleware('auth')->middleware('ensureUserRole:ADMIN PRODUK')->group(function () {


Route::get('adminproduk/dashboard', [DashboardController::class, 'adminprodukindex'])->name('adminproduk.dashboard');
Route::get('adminproduk/produk/index',[ProdukController::class,'adminprodukindex'])->name('adminproduk.produk.index');
Route::get('/download-template', [ProdukController::class,'download'])->name('download.template');
Route::post('/import-products', [ProdukController::class,'import'])->name('import.products');
Route::get('adminproduk/produk/create',[ProdukController::class,'adminprodukcreate'])->name('adminproduk.produk.create');
Route::post('adminproduk/produk/simpan',[ProdukController::class,'adminprodukstore'])->name('adminproduk.produk.simpan');
Route::get('/tampilproduk/{id}',[ProdukController::class,'adminprodukshow'])->name('tampilproduk');
Route::post('/updateproduk/{id}',[ProdukController::class,'adminprodukupdate'])->name('updateproduk');
Route::delete('/deleteproduk/{id}',[ProdukController::class,'adminprodukdestroy'])->name('deleteproduk');

});


//Admin Invoice
Route::middleware('auth')->middleware('ensureUserRole:ADMIN INVOICE')->group(function () {
Route::get('admininvoice/dashboard',[DashboardController::class,'admininvoiceindex'])->name('admininvoice.dashboard');

Route::get('admininvoice/customer/index',[CustomerController::class,'admininvoiceindex'])->name('admininvoice.customer.index');
Route::get('/download-template-customer', [CustomerController::class,'downloadtemplatecustomer'])->name('download.templatecustomer');
Route::post('/import-customer', [CustomerController::class,'importcustomer'])->name('import.customer');
Route::get('admininvoice/customer/create',[CustomerController::class,'admininvoicecreate'])->name('admininvoice.customer.create');
Route::post('admininvoice/customer/simpan',[CustomerController::class,'admininvoicestore'])->name('admininvoice.customer.simpan');
Route::get('/tampilcustomer/{id}',[CustomerController::class,'admininvoiceshow'])->name('tampilcustomer');
Route::post('/updatecustomer/{id}',[CustomerController::class,'admininvoiceupdate'])->name('updatecustomer');
Route::get('admininvoice/rfo/index',[RFOController::class,'admininvoiceindex'])->name('admininvoice.rfo.index');
Route::get('/admininvoice/so/create/{id}',[SOController::class,'admininvoicecreate'])->name('admininvoice.so.create');
Route::post('admininvoice/so/simpan',[SOController::class,'admininvoicestore'])->name('admininvoice.so.simpan');
Route::get('admininvoice/so/index',[SOController::class,'admininvoiceindex'])->name('admininvoice.so.index');
Route::get('/tampilso/{id}',[SOController::class,'tampilso'])->name('tampilso');
Route::get('/admininvoice/invoice/create/{id}', [InvoiceController::class,'admininvoicecreate'])->name('admininvoice.invoice.create');
Route::post('admininvoice/invoice/simpan',[InvoiceController::class,'admininvoicestore'])->name('admininvoice.invoice.simpan');
Route::get('admininvoice/invoice/index',[InvoiceController::class,'admininvoiceindex'])->name('admininvoice.invoice.index');
Route::get('/tampilinvoice/{id}',[InvoiceController::class, 'tampilinvoice'])->name('tampilinvoice');
Route::get('admininvoice/po/index',[POController::class,'admininvoiceindex'])-> name('admininvoice.po.index');
Route::post('admininvoice/po/create',[POController::class,'admininvoicecreate'])->name('admininvoice.po.create');
Route::post('admininvoice/po/simpan',[POController::class,'admininvoicesimpan'])->name('admininvoice.po.simpan');
Route::get('/tampilpo/{id}',[POController::class,'tampilpo'])->name('tampilpo');
Route::get('/tampildo/{id}',[DOController::class,'tampildo'])->name('tampildo');

Route::get('admininvoice/so/showrfo',[SOController::class,'showrfo'])->name('admininvoice.so.showrfo');
Route::get('admininvoice/po/showso',[POController::class,'showso'])->name('admininvoice.po.showso');

Route::get('admininvoice/invoice/showso',[InvoiceController::class,'showso'])->name('admininvoice.invoice.showso');

});

//Sales
Route::middleware('auth')->middleware('ensureUserRole:SALES')->group(function () {
Route::get('sales/dashboard',[DashboardController::class,'salesindex'])->name('sales.dashboard');

Route::get('sales/createrfo',[RFOController::class,'salescreate'])->name('sales.createrfo');
Route::post('sales/simpanrfo',[RFOController::class,'salesstore'])->name('sales.simpanrfo');
});


//Leader

Route::middleware('auth')->middleware('ensureUserRole:LEADER')->group(function () {
    Route::get('leader/dashboard',[DashboardController::class,'leaderindex'])->name('leader.dashboard');
    
    
    });