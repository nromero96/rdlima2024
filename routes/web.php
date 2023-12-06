<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UploadController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\HotelReservationController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\ExhibitorController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SpecialCodeController;


use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\CountryStateController;


use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/crear-enlace', function () {
    Artisan::call('storage:link');
    return "Enlace simbólico creado con éxito.";
});

//send test mail simple text use smtp config
// Route::get('/enviar-correo', function () {
//     $destinatario = 'niltondeveloper96@gmail.com';
//     Mail::to($destinatario)->send(new  \App\Mail\PruebaCorreo());
//     return "Correo enviado desde la ruta.";
// });

Route::get('/', function () {
    return view('auth.login');
});

//register
Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/online-form-invitations', [InvitationController::class, 'showOnlineForm_invitations'])->name('onlineforminvitations');
Route::post('/send-invitation', [InvitationController::class, 'sendInvitation'])->name('invitationsend');

Route::get('getcountry', [App\Http\Controllers\CountryStateController::class, 'getcountry'])->name('getcountry');
Route::post('upload',[UploadController::class, 'store']);

//routes for user login
Route::group(['middleware' => ['auth', 'ensureStatusActive']], function () {

    //Ejecutar migración
    Route::get('/ejecutar-migraciones', function () {
        Artisan::call('migrate');
        return 'Migraciones ejecutadas con éxito.';
    });

    // $this->middleware
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('/my-profile', [App\Http\Controllers\UserController::class, 'myprofile'])->name('users.myprofile');
    Route::post('/update-my-profile', [App\Http\Controllers\UserController::class, 'updatemyprofile'])->name('users.updatemyprofile');

    //Users
    Route::resource('users', UserController::class)->names('users');
    
    //Roles
    Route::resource('roles', RoleController::class)->names('roles');

    //Programs
    Route::resource('programs', ProgramController::class)->names('programs');

    //Inscriptions
    Route::resource('inscriptions', InscriptionController::class)->names('inscriptions');
    Route::put('inscriptions/{id}/update-status', [InscriptionController::class, 'updateStatus'])->name('inscriptions.updatestatus');
    Route::get('inscriptions-rejects', [InscriptionController::class, 'indexRejects'])->name('inscriptions.rejects');

    Route::get('/exportar-excel-inscriptions', [InscriptionController::class, 'exportExcelInscriptions'])->name('inscriptions.exportexcel');

    
    Route::get('payment-niubiz/{inscription}', [InscriptionController::class, 'paymentNiubiz'])->name('inscriptions.paymentniubiz');
    Route::post('confirm-payment-niubiz', [InscriptionController::class, 'confirmPaymentNiubiz'])->name('inscriptions.confirmpaymentniubiz');

    //HotelReservations
    Route::resource('hotelreservations', HotelReservationController::class)->names('hotelreservations');

    //Works
    Route::resource('works', WorkController::class)->names('works');
    Route::delete('/delete-file/{workId}/{fileNumber}', [WorkController::class, 'deleteFile'])->name('works.deletefile');

    //ExhibitorsController
    Route::resource('exhibitors', ExhibitorController::class)->names('exhibitors');

    //SpecialCodes
    Route::resource('specialcodes', SpecialCodeController::class)->names('specialcodes');
    Route::post('validate-specialcode', [SpecialCodeController::class, 'validateSpecialCode'])->name('specialcodes.validatespecialcode');

    //Invitations
    Route::resource('invitations', InvitationController::class)->names('invitations');



    Route::resource('suppliers', SupplierController::class)->names('suppliers');
    Route::resource('quotations', QuotationController::class)->names('quotations');

    //ruta para agregar servicios mediande ajax a proveedores
    Route::post('addservices-supplier', [SupplierController::class, 'addservices'])->name('suppliers.addservices');
    Route::post('updateservices-supplier', [SupplierController::class, 'updateservices'])->name('suppliers.updateservices');
    Route::get('getservices/{id}', [SupplierController::class, 'getservices'])->name('suppliergetservices');
    
    Route::get('servicesupplieredit', [SupplierController::class, 'servicesupplieredit'])->name('servicesupplieredit');
    Route::post('servicesupplierdelete', [SupplierController::class, 'servicesupplierdelete'])->name('servicesupplierdelete');

    Route::resource('customers', CustomerController::class)->names('customers');

    //Quotations Commercial
    Route::get('quotations-commercial', [QuotationController::class, 'index_commercial'])->name('quotations.commercial');

    //Quotatios Personal
    Route::get('quotations-personal', [QuotationController::class, 'index_personal'])->name('quotations.personal');
    
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendars.index');
    Route::get('calendar-listevents', [CalendarController::class, 'listevents'])->name('calendars.listevents');
    Route::post('calendar-ajax', [CalendarController::class, 'calendarajax'])->name('calendars.calendarajax');

    Route::get('notes', [NoteController::class,'index'])->name('notes.index');
    Route::post('store-notes', [NoteController::class,'store'])->name('notes.store');

    Route::get('changefavourite-note', [NoteController::class, 'changeFavourite'])->name('notes.changefavourite');
    Route::get('changetag-note', [NoteController::class, 'changeTag'])->name('notes.changetag');
    Route::get('destroy-note', [NoteController::class, 'destroy'])->name('notes.destroy');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');



//Localization Route
Route::get("locale/{lange}", [LocalizationController::class,'setLang']);

