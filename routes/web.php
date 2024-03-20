<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CancelController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DOController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\POController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\RFOController;
use App\Http\Controllers\SOController;
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
Route::post('superadmin/po/create',[POController::class,'superadmincreate'])->name('superadmin.po.create');
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
Route::post('admininvoice/po/create',[POController::class,'admininvoicecreate'])->name('admininvoice.po.create');
Route::post('admininvoice/po/simpan',[POController::class,'admininvoicesimpan'])->name('admininvoice.po.simpan');
Route::get('/tampilpo/{id}',[POController::class,'tampilpo'])->name('tampilpo');
Route::get('/tampildo/{id}',[DOController::class,'tampildo'])->name('tampildo');

Route::post('cancelpo',[POController::class,'cancelpo'])->name('cancelpo');
Route::post('cancelinvoice',[InvoiceController::class,'cancelinvoice'])->name('cancelinvoice');


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
});

//Sales
Route::middleware('auth')->middleware('ensureUserRole:SALES')->group(function () {
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

    });

    //MANAGER
    Route::middleware('auth')->middleware('ensureUserRole:MANAGER')->group(function () {
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

    });