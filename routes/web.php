<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CancelController;
use App\Http\Controllers\CatatanController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DOController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RFOController;
use App\Http\Controllers\SOController;
use App\Http\Controllers\SumberController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserAccountController;
use App\Models\CancelApproval;
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


    Route::get('superadmin/quotation/index',[QuotationController::class,'superadminindex'])->name('superadmin.quotation.index');
    Route::get('superadmin/createquote',[QuotationController::class,'superadmincreate'])->name('superadmin.createquote');
    Route::post('superadmin/simpanquotation',[QuotationController::class,'superadminstore'])->name('superadmin.simpanquotation');
    Route::get('/superadmintampilpesananquote/{id}',[QuotationController::class,'superadmintampilpesananquote'])->name('superadmintampilpesananquote');
    Route::get('/superadmintampilquote/{id}',[QuotationController::class,'superadmintampilquote'])->name('superadmintampilquote');
    Route::post('superadmincancelquotation',[QuotationController::class,'superadmincancelquotation'])->name('superadmincancelquotation');



    Route::get('superadmin/createrfo',[RFOController::class,'superadmincreate'])->name('superadmin.createrfo');
    Route::post('superadmin/simpanrfo',[RFOController::class,'superadminstore'])->name('superadmin.simpanrfo');
    Route::post('superadmincancelorder',[RFOController::class,'superadmincancelorder'])->name('superadmincancelorder');


    Route::get('/superadmin-get-products-by-supplier', [ProdukController::class,'superadmingetProductsBySupplier']);


Route::get('superadmin/dashboard', [DashboardController::class, 'superadminindex'])->name('superadmin.dashboard');
Route::get('superadmin/useraccount/index', [UserAccountController::class, 'superadminindex'])->name('superadmin.useraccount.index');
Route::get('superadmin/useraccount/create', [UserAccountController::class, 'superadmincreate'])->name('superadmin.useraccount.create');
Route::post('superadmin/useraccount/simpan', [UserAccountController::class, 'superadminstore'])->name('superadmin.useraccount.simpan');
Route::get('/tampiluser/{id}', [UserAccountController::class, 'superadminshow'])->name('tampiluser');
Route::post('/updateuser/{id}', [UserAccountController::class, 'superadminupdate'])->name('updateuser');
Route::delete('/deleteuser/{id}', [UserAccountController::class, 'superadmindestroy'])->name('deleteuser');
Route::post('/reset-password', [UserAccountController::class,'superadminresetPassword'])->name('reset-password');


Route::get('superadmin/customer/index',[CustomerController::class,'superadminindex'])->name('superadmin.customer.index');
Route::get('/superadmin-download-template-customer', [CustomerController::class,'superadmindownloadtemplatecustomer'])->name('superadmindownload.templatecustomer');
Route::post('/superadminimport-customer', [CustomerController::class,'superadminimportcustomer'])->name('superadminimport.customer');
Route::get('superadmin/customer/create',[CustomerController::class,'superadmincreate'])->name('superadmin.customer.create');
Route::post('superadmin/customer/simpan',[CustomerController::class,'superadminstore'])->name('superadmin.customer.simpan');
Route::get('/superadmintampilcustomer/{id}',[CustomerController::class,'superadminshow'])->name('superadmintampilcustomer');
Route::post('/superadminupdatecustomer/{id}',[CustomerController::class,'superadminupdatecustomer'])->name('superadminupdatecustomer');
Route::delete('superadmin/customerdelete/{id}', [CustomerController::class,'superadmindestroy'])->name('superadmin.customerdelete');

Route::get('superadmin/po/index',[POController::class,'superadminindex'])-> name('superadmin.po.index');
Route::get('/superadmininfocancel/{id}',[CancelController::class,'superadmininfocancel'])->name('superadmininfocancel');
Route::post('superadminapprovecancel',[CancelController::class,'superadminapprovecancel'])->name('superadminapprovecancel');


Route::get('superadmin/invoice/index',[InvoiceController::class,'superadminindex'])->name('superadmin.invoice.index');
Route::get('/superadmininfocancelinvoice/{id}',[CancelController::class,'superadmininfocancelinvoice'])->name('superadmininfocancelinvoice');
Route::post('superadminapprovecancelinvoice',[CancelController::class,'superadminapprovecancelinvoice'])->name('superadminapprovecancelinvoice');


Route::get('superadmin/produk/index',[ProdukController::class,'superadminindex'])->name('superadmin.produk.index');
Route::get('/superadmindownload-template', [ProdukController::class,'superadmindownload'])->name('superadmindownload.template');
Route::post('/superadminimport-products', [ProdukController::class,'superadminimport'])->name('superadminimport.products');
Route::get('superadmin/produk/create',[ProdukController::class,'superadmincreate'])->name('superadmin.produk.create');
Route::post('superadmin/produk/simpan',[ProdukController::class,'superadminstore'])->name('superadmin.produk.simpan');
Route::get('/superadmintampilproduk/{id}',[ProdukController::class,'superadminshow'])->name('superadmintampilproduk');
Route::post('/superadminupdateproduk/{id}',[ProdukController::class,'superadminupdate'])->name('superadminupdateproduk');
Route::delete('/superadmindeleteproduk/{id}',[ProdukController::class,'superadmindestroy'])->name('superadmindeleteproduk');


Route::get('superadmin/rfo/index',[RFOController::class,'superadminindex'])->name('superadmin.rfo.index');
Route::get('/superadmintampilpesanan/{id}',[RFOController::class,'superadmintampilpesanan'])->name('superadmintampilpesanan');


Route::get('superadmin/so/index',[SOController::class,'superadminindex'])->name('superadmin.so.index');
Route::get('/superadmintampilpesananso/{id}',[SOController::class,'superadmintampilpesananso'])->name('superadmintampilpesananso');
Route::get('superadmin/so/showrfo',[SOController::class,'superadminshowrfo'])->name('superadmin.so.showrfo');

Route::get('/superadmin/so/create/{id}',[SOController::class,'superadmincreate'])->name('superadmin.so.create');
Route::post('superadmin/so/simpan',[SOController::class,'superadminstore'])->name('superadmin.so.simpan');

Route::get('superadmin/po/showso',[POController::class,'superadminshowso'])->name('superadmin.po.showso');
Route::get('/superadmintampilso/{id}',[SOController::class,'superadmintampilso'])->name('superadmintampilso');

Route::get('/superadmintampilpesananpo/{id}',[POController::class,'superadmintampilpesananpo'])->name('superadmintampilpesananpo');
Route::get('/superadmintampilsoquote/{id}',[POController::class,'superadmintampilsoquote'])->name('superadmintampilsoquote');

Route::get('/superadmintampilpo/{id}',[POController::class,'superadmintampilpo'])->name('superadmintampilpo');
Route::get('superadmin/po/create',[POController::class,'superadmincreate'])->name('superadmin.po.create');
Route::post('superadmin/po/simpan',[POController::class,'superadminsimpan'])->name('superadmin.po.simpan');
Route::get('/superadmintampilpesananinvoice/{id}',[InvoiceController::class,'superadmintampilpesananinvoice'])->name('superadmintampilpesananinvoice');
Route::get('/superadmintampilinvoice/{id}',[InvoiceController::class, 'superadmintampilinvoice'])->name('superadmintampilinvoice');
Route::get('/superadmintampildo/{id}',[DOController::class,'superadmintampildo'])->name('superadmintampildo');
Route::get('superadmin/invoice/showso',[InvoiceController::class,'superadminshowso'])->name('superadmin.invoice.showso');
Route::get('/superadmin/invoice/create/{id}', [InvoiceController::class,'superadmincreate'])->name('superadmin.invoice.create');
Route::post('superadmin/invoice/simpan',[InvoiceController::class,'superadminstore'])->name('superadmin.invoice.simpan');
Route::get('/superadmin/invoice/createquote/{id}', [InvoiceController::class,'superadmincreatequote'])->name('superadmin.invoice.createquote');
Route::post('superadmin/invoice/simpanquote',[InvoiceController::class,'superadminstorequote'])->name('superadmin.invoice.simpanquote');
Route::post('superadmincancelinvoice',[InvoiceController::class,'superadmincancelinvoice'])->name('superadmincancelinvoice');

Route::post('superadmincancelpo',[POController::class,'superadmincancelpo'])->name('superadmincancelpo');
Route::post('superadmincancelso',[SOController::class,'superadmincancelso'])->name('superadmincancelso');

Route::post('superadminclosinginvoice',[InvoiceController::class,'superadminclosinginvoice'])->name('superadminclosinginvoice');

Route::get('/superadminfilter', [DashboardController::class, 'superadminfilter'])->name('superadminfilter');

Route::get('superadmin/changepassword', [UserAccountController::class,'superadminchangepasswordindex'])->name('superadminpassword');
Route::post('superadmin/changepassword', [UserAccountController::class,'superadminchangePassword'])->name('superadmin-change-password');
Route::post('/user/{user}/reset-password', [UserAccountController::class,'resetPassword'])->name('superadmin.reset-password');

Route::get('superadmin/perubahaninvoice/{id}',[InvoiceController::class,'superadminperubahan'])->name('superadmin.perubahaninvoice');
Route::post('superadminupdateinvoice/{id}',[InvoiceController::class,'superadminupdateinvoice'])->name('superadminupdateinvoice');

Route::get('superadmin/channel/index',[ChannelController::class,'superadminindex'])->name('superadmin.channel.index');

Route::get('superadmin/channel/create',[ChannelController::class,'superadmincreate'])->name('superadmin.channel.create');
Route::post('superadmin/channel/simpan',[ChannelController::class,'superadminstore'])->name('superadmin.channel.simpan');

Route::get('/tampilchannel/{id}',[ChannelController::class,'superadminshow'])->name('tampilchannel');
Route::post('/updatechannel/{id}',[ChannelController::class,'superadminupdate'])->name('updatechannel');
Route::delete('/deletechannel/{id}',[ChannelController::class,'adminprodukdestroy'])->name('deletechannel');


Route::get('superadmin/createpochannel', [POController::class,'superadmincreatePO'])->name('superadmin.po.createpochannel');
Route::post('superadmin/po/simpanpochannel',[POController::class,'superadminsimpanpochannel'])->name('superadmin.po.simpanpochannel');
Route::get('superadmin/po/showsupplier',[POController::class,'superadminshowsupplier'])->name('superadmin.po.showsupplier');

Route::get('superadmin/supplier/index', [SupplierController::class,'superadminindex'])->name('superadmin.supplier.index');
Route::get('superadmin/supplier/create', [SupplierController::class,'superadmincreate'])->name('superadmin.supplier.create');

Route::post('superadmin/supplier/simpan', [SupplierController::class,'superadminstore'])->name('superadmin.supplier.simpan');
Route::get('/superadmintampilsupplier/{id}',[SupplierController::class,'superadminshow'])->name('superadmintampilsupplier');
Route::post('/superadminupdatesupplier/{id}',[SupplierController::class,'superadminupdate'])->name('superadminupdatesupplier');
Route::delete('/superadmindeletesupplier/{id}',[SupplierController::class,'superadmindestroy'])->name('superadmindeletesupplier');



Route::get('superadmin/kategori/index',[KategoriController::class,'superadminindex'])->name('superadmin.kategori.index');
Route::get('superadmin/kategori/create',[KategoriController::class,'superadmincreate'])->name('superadmin.kategori.create');
Route::post('superadmin/kategori/simpan',[KategoriController::class,'superadminstore'])->name('superadmin.kategori.simpan');
Route::get('/superadmintampilkategori/{id}',[KategoriController::class,'superadminshow'])->name('superadmintampilkategori');
Route::delete('/superadmindelekategori/{id}',[KategoriController::class,'superadmindestroy'])->name('superadmindeletekategori');
Route::post('/superadminupdatekategori/{id}',[KategoriController::class,'superadminupdate'])->name('superadminupdatekategori');

Route::get('superadmin/sumber/index',[SumberController::class,'superadminindex'])->name('superadmin.sumber.index');
Route::get('superadmin/sumber/create',[SumberController::class,'superadmincreate'])->name('superadmin.sumber.create');
Route::post('superadmin/sumber/simpan',[SumberController::class,'superadminstore'])->name('superadmin.sumber.simpan');
Route::get('/superadmintampilsumber/{id}',[SumberController::class,'superadminshow'])->name('superadmintampilsumber');
Route::delete('/superadmindelesumber/{id}',[SumberController::class,'superadmindestroy'])->name('superadmindeletesumber');
Route::post('/superadminupdatesumber/{id}',[SumberController::class,'superadminupdate'])->name('superadminupdatesumber');


Route::get('superadmin/catatan/index',[CatatanController::class,'superadminindex'])->name('superadmin.catatan.index');
Route::get('superadmin/catatan/create',[CatatanController::class,'superadmincreate'])->name('superadmin.catatan.create');
Route::post('superadmin/catatan/simpan',[CatatanController::class,'superadminstore'])->name('superadmin.catatan.simpan');
Route::get('/superadmintampilcatatan/{id}',[CatatanController::class,'superadminshow'])->name('superadmintampilcatatan');
Route::delete('/superadmindelecatatan/{id}',[CatatanController::class,'superadmindestroy'])->name('superadmindeletecatatan');
Route::post('/superadminupdatecatatan/{id}',[CatatanController::class,'superadminupdate'])->name('superadminupdatecatatan');

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

Route::get('adminproduk/changepassword', [UserAccountController::class,'adminprodukchangepasswordindex'])->name('adminprodukpassword');
Route::post('adminproduk/changepassword', [UserAccountController::class,'adminprodukchangePassword'])->name('adminproduk-change-password');


Route::get('adminproduk/supplier/index', [SupplierController::class,'adminprodukindex'])->name('adminproduk.supplier.index');
Route::get('adminproduk/supplier/create', [SupplierController::class,'adminprodukcreate'])->name('adminproduk.supplier.create');

Route::post('adminproduk/supplier/simpan', [SupplierController::class,'adminprodukstore'])->name('adminproduk.supplier.simpan');
Route::get('/tampilsupplier/{id}',[SupplierController::class,'adminprodukshow'])->name('tampilsupplier');
Route::post('/updatesupplier/{id}',[SupplierController::class,'adminprodukupdate'])->name('updatesupplier');
Route::delete('/deletesupplier/{id}',[SupplierController::class,'adminprodukdestroy'])->name('deletesupplier');

});


//Admin Invoice
Route::middleware('auth')->middleware('ensureUserRole:ADMIN INVOICE')->group(function () {
Route::get('admininvoice/dashboard',[DashboardController::class,'admininvoiceindex'])->name('admininvoice.dashboard');

Route::delete('admininvoice/customerdelete/{id}', [CustomerController::class,'admininvoicedestroy'])->name('admininvoice.customerdelete');
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
Route::get('admininvoice/po/create',[POController::class,'admininvoicecreate'])->name('admininvoice.po.create');
Route::post('admininvoice/po/simpan',[POController::class,'admininvoicesimpan'])->name('admininvoice.po.simpan');
Route::get('/tampilpo/{id}',[POController::class,'tampilpo'])->name('tampilpo');
Route::get('/tampildo/{id}',[DOController::class,'tampildo'])->name('tampildo');

Route::post('cancelpo',[POController::class,'cancelpo'])->name('cancelpo');
Route::post('cancelinvoice',[InvoiceController::class,'cancelinvoice'])->name('cancelinvoice');

Route::post('updateinvoice/{id}',[InvoiceController::class,'updateinvoice'])->name('updateinvoice');


Route::post('closinginvoice',[InvoiceController::class,'closinginvoice'])->name('closinginvoice');


Route::get('admininvoice/so/showrfo',[SOController::class,'showrfo'])->name('admininvoice.so.showrfo');
Route::get('admininvoice/po/showso',[POController::class,'showso'])->name('admininvoice.po.showso');

Route::get('admininvoice/invoice/showso',[InvoiceController::class,'showso'])->name('admininvoice.invoice.showso');
Route::get('/admininvoice/invoice/createquote/{id}', [InvoiceController::class,'admininvoicecreatequote'])->name('admininvoice.invoice.createquote');
Route::post('admininvoice/invoice/simpanquote',[InvoiceController::class,'admininvoicestorequote'])->name('admininvoice.invoice.simpanquote');

Route::get('/admininvoicetampilpesanan/{id}',[RFOController::class,'admininvoicetampilpesanan'])->name('admininvoicetampilpesanan');


Route::get('/tampilpesananso/{id}',[SOController::class,'tampilpesananso'])->name('tampilpesananso');
Route::get('/tampilpesananpo/{id}',[POController::class,'tampilpesananpo'])->name('tampilpesananpo');

Route::get('/tampilsoquote/{id}',[POController::class,'tampilsoquote'])->name('tampilsoquote');

Route::get('/tampilpesananinvoice/{id}',[InvoiceController::class,'tampilpesananinvoice'])->name('tampilpesananinvoice');

Route::post('cancelorderadmin',[SOController::class,'cancelorderadmin'])->name('cancelorderadmin');
Route::post('/sales-order/{id}/download', [SOController::class,'download'])->name('sales-order.download');

Route::post('/purchase-order/{id}/download', [POController::class,'download'])->name('purchase-order.download');

Route::post('/invoice/{id}/download', [InvoiceController::class,'download'])->name('invoice.download');
Route::post('/do/{id}/download', [InvoiceController::class,'downloaddo'])->name('do.download');

Route::get('admininvoice/changepassword', [UserAccountController::class,'admininvoicechangepasswordindex'])->name('password');
Route::post('admininvoice/changepassword', [UserAccountController::class,'admininvoicechangePassword'])->name('admininvoice-change-password');
Route::get('/filter', [DashboardController::class, 'filter'])->name('filter');

Route::get('admininvoice/perubahaninvoice/{id}',[InvoiceController::class,'admininvoiceperubahan'])->name('admininvoice.perubahaninvoice');
Route::get('admininvoice/po/showchannel',[POController::class,'showchannel'])->name('admininvoice.po.showchannel');
Route::get('admininvoice/po/showsupplier',[POController::class,'showsupplier'])->name('admininvoice.po.showsupplier');

Route::get('admininvoice/createpochannel', [POController::class,'createPO'])->name('admininvoice.po.createpochannel');
Route::post('admininvoice/po/simpanpochannel',[POController::class,'simpanpochannel'])->name('admininvoice.po.simpanpochannel');

Route::get('/get-products-by-supplier', [ProdukController::class,'getProductsBySupplier']);
Route::get('/get-product-price',  [ProdukController::class,'getProductPrice'])->name('get-product-price');

Route::get('admininvoice/catatan/index',[CatatanController::class,'admininvoiceindex'])->name('admininvoice.catatan.index');
Route::get('admininvoice/catatan/create',[CatatanController::class,'admininvoicecreate'])->name('admininvoice.catatan.create');
Route::post('admininvoice/catatan/simpan',[CatatanController::class,'admininvoicestore'])->name('admininvoice.catatan.simpan');
Route::get('/admininvoicetampilcatatan/{id}',[CatatanController::class,'admininvoiceshow'])->name('admininvoicetampilcatatan');
Route::delete('/admininvoicedelecatatan/{id}',[CatatanController::class,'admininvoicedestroy'])->name('admininvoicedeletecatatan');
Route::post('/admininvoiceupdatecatatan/{id}',[CatatanController::class,'admininvoiceupdate'])->name('admininvoiceupdatecatatan');



});

//Sales
Route::middleware('auth')->middleware('ensureUserRole:SALES')->group(function () {

    Route::get('/editquote/{id}',[QuotationController::class,'salesshow'])->name('editquote');
    Route::post('/salesupdatequote/{id}',[QuotationController::class,'salesupdate'])->name('salesupdatequote');
    
Route::get('sales/dashboard',[DashboardController::class,'salesindex'])->name('sales.dashboard');

Route::get('sales/rfo/index',[RFOController::class,'salesindex'])->name('sales.rfo.index');
Route::get('sales/createrfo',[RFOController::class,'salescreate'])->name('sales.createrfo');
Route::post('sales/simpanrfo',[RFOController::class,'salesstore'])->name('sales.simpanrfo');


Route::get('sales/quotation/index',[QuotationController::class,'salesindex'])->name('sales.quotation.index');
Route::get('sales/createquote',[QuotationController::class,'salescreate'])->name('sales.createquote');
Route::post('sales/simpanquotation',[QuotationController::class,'salesstore'])->name('sales.simpanquotation');

Route::get('/tampilquote/{id}',[QuotationController::class,'tampilquote'])->name('tampilquote');


Route::post('cancelorder',[RFOController::class,'cancelorder'])->name('cancelorder');

Route::post('cancelquotation',[QuotationController::class,'cancelquotation'])->name('cancelquotation');

Route::post('cancelorderbaru',[RFOController::class,'cancelorderbaru'])->name('cancelorderbaru');


Route::get('/tampilpesanan/{id}',[RFOController::class,'tampilpesanan'])->name('tampilpesanan');
Route::get('/tampilpesananquote/{id}',[QuotationController::class,'tampilpesananquote'])->name('tampilpesananquote');


Route::post('/quotation/{id}/download', [QuotationController::class,'download'])->name('quotation.download');
Route::post('/leaderquotation/{id}/download', [QuotationController::class,'leaderdownload'])->name('leaderquotation.download');
Route::get('sales/changepassword', [UserAccountController::class,'saleschangepasswordindex'])->name('salespassword');
Route::post('sales/changepassword', [UserAccountController::class,'saleschangePassword'])->name('sales-change-password');



});


//Leader

Route::middleware('auth')->middleware('ensureUserRole:LEADER')->group(function () {
    Route::get('/leadereditquote/{id}',[QuotationController::class,'leadershow'])->name('leadereditquote');
    Route::post('/leaderupdatequote/{id}',[QuotationController::class,'leaderupdate'])->name('leaderupdatequote');
    Route::get('leader/dashboard',[DashboardController::class,'leaderindex'])->name('leader.dashboard');
    Route::get('leader/rfo/index',[RFOController::class,'leaderindex'])->name('leader.rfo.index');

    Route::get('/infocancel/{id}',[CancelController::class,'infocancel'])->name('infocancel');

    Route::post('approvecancel',[CancelController::class,'approvecancel'])->name('approvecancel');
    Route::post('approvecancelquote',[CancelController::class,'approvecancelquote'])->name('approvecancelquote');

    Route::get('leader/createrfo',[RFOController::class,'leadercreate'])->name('leader.createrfo');

    Route::post('leader/simpanrfo',[RFOController::class,'leaderstore'])->name('leader.simpanrfo');

    Route::get('leader/quotation/index',[QuotationController::class,'leaderindex'])->name('leader.quotation.index');
    Route::get('/infocancelquotation/{id}',[CancelController::class,'infocancelquotation'])->name('infocancelquotation');

    Route::get('leader/createquote',[QuotationController::class,'leadercreate'])->name('leader.createquote');

    Route::get('/leadertampilpesanan/{id}',[RFOController::class,'leadertampilpesanan'])->name('leadertampilpesanan');
    Route::get('/leadertampilpesananquote/{id}',[QuotationController::class,'leadertampilpesananquote'])->name('leadertampilpesananquote');

    Route::post('leader/simpanquotation',[QuotationController::class,'leaderstore'])->name('leader.simpanquotation');

    Route::get('/leadertampilquote/{id}',[QuotationController::class,'leadertampilquote'])->name('leadertampilquote');
    Route::post('leadercancelorder',[RFOController::class,'leadercancelorder'])->name('leadercancelorder');


    Route::post('leadercancelquotation',[QuotationController::class,'leadercancelquotation'])->name('leadercancelquotation');


    Route::get('leader/customer/index',[CustomerController::class,'leaderindex'])->name('leader.customer.index');


    Route::get('/leader-download-template-customer', [CustomerController::class,'leaderdownloadtemplatecustomer'])->name('leaderdownload.templatecustomer');
    Route::post('/leaderimport-customer', [CustomerController::class,'leaderimportcustomer'])->name('leaderimport.customer');

    Route::get('leader/customer/create',[CustomerController::class,'leadercreate'])->name('leader.customer.create');

    Route::post('leader/customer/simpan',[CustomerController::class,'leaderstore'])->name('leader.customer.simpan');
    Route::get('/leadertampilcustomer/{id}',[CustomerController::class,'leadershow'])->name('leadertampilcustomer');
    Route::post('/leaderupdatecustomer/{id}',[CustomerController::class,'leaderupdatecustomer'])->name('leaderupdatecustomer');

    Route::delete('leader/customerdelete/{id}', [CustomerController::class,'leaderdestroy'])->name('leader.customerdelete');

    Route::get('leader/changepassword', [UserAccountController::class,'leaderchangepasswordindex'])->name('leaderpassword');
Route::post('leader/changepassword', [UserAccountController::class,'leaderchangePassword'])->name('leader-change-password');


Route::get('leader/channel/index',[ChannelController::class,'leaderindex'])->name('leader.channel.index');

Route::get('leader/channel/create',[ChannelController::class,'leadercreate'])->name('leader.channel.create');
Route::post('leader/channel/simpan',[ChannelController::class,'leaderstore'])->name('leader.channel.simpan');

Route::get('/leadertampilchannel/{id}',[ChannelController::class,'leadershow'])->name('leadertampilchannel');
Route::post('/leaderupdatechannel/{id}',[ChannelController::class,'leaderupdate'])->name('leaderupdatechannel');
Route::delete('/leaderdeletechannel/{id}',[ChannelController::class,'leaderdestroy'])->name('leaderdeletechannel');



Route::get('leader/kategori/index',[KategoriController::class,'leaderindex'])->name('leader.kategori.index');
Route::get('leader/kategori/create',[KategoriController::class,'leadercreate'])->name('leader.kategori.create');
Route::post('leader/kategori/simpan',[KategoriController::class,'leaderstore'])->name('leader.kategori.simpan');
Route::get('/leadertampilkategori/{id}',[KategoriController::class,'leadershow'])->name('leadertampilkategori');
Route::delete('/leaderdelekategori/{id}',[KategoriController::class,'leaderdestroy'])->name('leaderdeletekategori');
Route::post('/leaderupdatekategori/{id}',[KategoriController::class,'leaderupdate'])->name('leaderupdatekategori');


Route::get('leader/sumber/index',[SumberController::class,'leaderindex'])->name('leader.sumber.index');
Route::get('leader/sumber/create',[SumberController::class,'leadercreate'])->name('leader.sumber.create');
Route::post('leader/sumber/simpan',[SumberController::class,'leaderstore'])->name('leader.sumber.simpan');
Route::get('/leadertampilsumber/{id}',[SumberController::class,'leadershow'])->name('leadertampilsumber');
Route::delete('/leaderdelesumber/{id}',[SumberController::class,'leaderdestroy'])->name('leaderdeletesumber');
Route::post('/leaderupdatesumber/{id}',[SumberController::class,'leaderupdate'])->name('leaderupdatesumber');

Route::post('/leaderquotation/{id}/download', [QuotationController::class,'leaderdownload'])->name('leaderquotation.download');

    });

    //MANAGER
    Route::middleware('auth')->middleware('ensureUserRole:MANAGER')->group(function () {

        Route::get('manager/so/index',[SOController::class,'managerindex'])->name('manager.so.index');
        Route::get('/managertampilpesananso/{id}',[SOController::class,'managertampilpesananso'])->name('managertampilpesananso');
        Route::get('/managertampilso/{id}',[SOController::class,'managertampilso'])->name('managertampilso');


        Route::get('/managertampilpo/{id}',[POController::class,'managertampilpo'])->name('managertampilpo');
Route::get('manager/po/index',[POController::class,'managerindex'])-> name('manager.po.index');
Route::get('/managertampilpesananpo/{id}',[POController::class,'managertampilpesananpo'])->name('managertampilpesananpo');
Route::get('/managertampilsoquote/{id}',[POController::class,'managertampilsoquote'])->name('managertampilsoquote');



Route::get('manager/invoice/index',[InvoiceController::class,'managerindex'])->name('manager.invoice.index');
Route::get('/managertampilpesananinvoice/{id}',[InvoiceController::class,'managertampilpesananinvoice'])->name('managertampilpesananinvoice');
Route::get('/managertampilinvoice/{id}',[InvoiceController::class, 'managertampilinvoice'])->name('managertampilinvoice');
Route::get('/managertampildo/{id}',[DOController::class,'managertampildo'])->name('managertampildo');

        Route::get('/managereditquote/{id}',[QuotationController::class,'managershow'])->name('managereditquote');
        Route::post('/managerupdatequote/{id}',[QuotationController::class,'managerupdate'])->name('managerupdatequote');


        Route::post('/managerquotation/{id}/download', [QuotationController::class,'managerdownload'])->name('managerquotation.download');

        Route::get('manager/dashboard',[DashboardController::class,'managerindex'])->name('manager.dashboard');
        Route::get('manager/dashboarddata',[DashboardController::class,'managerdashboarddata'])->name('manager.dashboarddata');

        Route::get('manager/rfo/index',[RFOController::class,'managerindex'])->name('manager.rfo.index');

        Route::get('manager/quotation/index',[QuotationController::class,'managerindex'])->name('manager.quotation.index');

        Route::get('/managerinfocancel/{id}',[CancelController::class,'managerinfocancel'])->name('managerinfocancel');
        Route::post('managerapprovecancel',[CancelController::class,'managerapprovecancel'])->name('managerapprovecancel');
        Route::get('/managerinfocancelquotation/{id}',[CancelController::class,'managerinfocancelquotation'])->name('managerinfocancelquotation');
        Route::get('/managertampilpesanan/{id}',[RFOController::class,'managertampilpesanan'])->name('managertampilpesanan');


        Route::get('/managertampilpesananquote/{id}',[QuotationController::class,'managertampilpesananquote'])->name('managertampilpesananquote');
        Route::post('managerapprovecancelquote',[CancelController::class,'managerapprovecancelquote'])->name('managerapprovecancelquote');
        Route::get('/managertampilquote/{id}',[QuotationController::class,'managertampilquote'])->name('managertampilquote');


        Route::get('manager/createrfo',[RFOController::class,'managercreate'])->name('manager.createrfo');
        Route::post('manager/simpanrfo',[RFOController::class,'managerstore'])->name('manager.simpanrfo');
        Route::get('manager/createquote',[QuotationController::class,'managercreate'])->name('manager.createquote');
        Route::post('manager/simpanquotation',[QuotationController::class,'managerstore'])->name('manager.simpanquotation');



        Route::get('manager/customer/index',[CustomerController::class,'managerindex'])->name('manager.customer.index');


        Route::get('/manager-download-template-customer', [CustomerController::class,'managerdownloadtemplatecustomer'])->name('managerdownload.templatecustomer');
        Route::post('/managerimport-customer', [CustomerController::class,'managerimportcustomer'])->name('managerimport.customer');
    
        Route::get('manager/customer/create',[CustomerController::class,'managercreate'])->name('manager.customer.create');
    
        Route::post('manager/customer/simpan',[CustomerController::class,'managerstore'])->name('manager.customer.simpan');
        Route::get('/managertampilcustomer/{id}',[CustomerController::class,'managershow'])->name('managertampilcustomer');
        Route::post('/managerupdatecustomer/{id}',[CustomerController::class,'managerupdatecustomer'])->name('managerupdatecustomer');
        Route::delete('manager/customerdelete/{id}', [CustomerController::class,'managerdestroy'])->name('manager.customerdelete');

        Route::get('manager/changepassword', [UserAccountController::class,'managerchangepasswordindex'])->name('managerpassword');
        Route::post('manager/changepassword', [UserAccountController::class,'managerchangePassword'])->name('manager-change-password');
        Route::get('/managerfilter', [DashboardController::class, 'managerfilter'])->name('managerfilter');

        Route::get('manager/approval', [CancelController::class,'managerapprovalindex'])->name('managerapproval');
        Route::get('/managerinfocancelpo/{id}',[CancelController::class,'managerinfocancelpo'])->name('managerinfocancelpo');
        Route::post('managerapprovecancelpo',[CancelController::class,'managerapprovecancelpo'])->name('managerapprovecancelpo');
        Route::get('/managerinfocancelinvoice/{id}',[CancelController::class,'managerinfocancelinvoice'])->name('managerinfocancelinvoice');
        Route::post('managerapprovecancelinvoice',[CancelController::class,'managerapprovecancelinvoice'])->name('managerapprovecancelinvoice');


Route::post('managercancelrfo',[RFOController::class,'managercancelrfo'])->name('managercancelrfo');
Route::post('managercancelquote',[QuotationController::class,'managercancelquote'])->name('managercancelquote');

Route::get('manager/channel/index',[ChannelController::class,'managerindex'])->name('manager.channel.index');

Route::get('manager/channel/create',[ChannelController::class,'managercreate'])->name('manager.channel.create');
Route::post('manager/channel/simpan',[ChannelController::class,'managerstore'])->name('manager.channel.simpan');

Route::get('/managertampilchannel/{id}',[ChannelController::class,'managershow'])->name('managertampilchannel');
Route::post('/managerupdatechannel/{id}',[ChannelController::class,'managerupdate'])->name('managerupdatechannel');
Route::delete('/managerdeletechannel/{id}',[ChannelController::class,'managerdestroy'])->name('managerdeletechannel');

Route::get('manager/kategori/index',[KategoriController::class,'managerindex'])->name('manager.kategori.index');
Route::get('manager/kategori/create',[KategoriController::class,'managercreate'])->name('manager.kategori.create');
Route::post('manager/kategori/simpan',[KategoriController::class,'managerstore'])->name('manager.kategori.simpan');
Route::get('/managertampilkategori/{id}',[KategoriController::class,'managershow'])->name('managertampilkategori');
Route::delete('/managerdelekategori/{id}',[KategoriController::class,'managerdestroy'])->name('managerdeletekategori');
Route::post('/managerupdatekategori/{id}',[KategoriController::class,'managerupdate'])->name('managerupdatekategori');

Route::get('manager/sumber/index',[SumberController::class,'managerindex'])->name('manager.sumber.index');
Route::get('manager/sumber/create',[SumberController::class,'managercreate'])->name('manager.sumber.create');
Route::post('manager/sumber/simpan',[SumberController::class,'managerstore'])->name('manager.sumber.simpan');
Route::get('/managertampilsumber/{id}',[SumberController::class,'managershow'])->name('managertampilsumber');
Route::delete('/managerdelesumber/{id}',[SumberController::class,'managerdestroy'])->name('managerdeletesumber');
Route::post('/managerupdatesumber/{id}',[SumberController::class,'managerupdate'])->name('managerupdatesumber');



Route::get('manager/catatan/index',[CatatanController::class,'managerindex'])->name('manager.catatan.index');
Route::get('manager/catatan/create',[CatatanController::class,'managercreate'])->name('manager.catatan.create');
Route::post('manager/catatan/simpan',[CatatanController::class,'managerstore'])->name('manager.catatan.simpan');
Route::get('/managertampilcatatan/{id}',[CatatanController::class,'managershow'])->name('managertampilcatatan');
Route::delete('/managerdelecatatan/{id}',[CatatanController::class,'managerdestroy'])->name('managerdeletecatatan');
Route::post('/managerupdatecatatan/{id}',[CatatanController::class,'managerupdate'])->name('managerupdatecatatan');

});