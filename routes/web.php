<?php

use App\Mail\Test;
use App\Mail\InvoiceMail;
use App\Http\Livewire\Invoicewr;
use App\Http\Livewire\Packagewr;
use App\Http\Livewire\Customerwr;
use App\Http\Livewire\Addinvoicewr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Createinvoicewr;
use App\Http\Livewire\Updateinvoicewr;
use App\Http\Livewire\Createquotationwr;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Updatedetailinvoicewr;
use App\Http\Controllers\InvoiceEmailController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');




Route::get('/customer', Customerwr::class)->name('customer');
Route::get('/package', Packagewr::class)->name('package');
Route::get('/invoice', Invoicewr::class)->name('invoice');
Route::get('/createinvoice', Createinvoicewr::class)->name('createinvoice');
Route::get('/updateinvoice/{current_number}', Updateinvoicewr::class)->name('updateinvoice');
Route::get('/updatedetailinvoice/{current_id}/{number}', Updatedetailinvoicewr::class)->name('updatedetailinvoice');
Route::get('/addinvoice/{number}', Addinvoicewr::class)->name('addinvoice');
Route::get('/quotation', Createquotationwr::class)->name('quotation');

Route::get('/pdftemplate/{number}', [InvoiceEmailController::class, 'index']);
Route::get('/pdf/{number}', [InvoiceEmailController::class, 'pdf']);
Route::get('/emailinvoice/{number}', [InvoiceEmailController::class, 'emailinvoice']);
Route::get('/kirimemail/{number}', [InvoiceEmailController::class, 'kirimemail']);

});
Route::get('/emailhtml', [InvoiceEmailController::class, 'emailhtml']);

// Route::get('/invoicemail/{number}', [InvoiceMail::class]);
Route::get('/invoicemail/{number}', function() {
    Mail::send(new InvoiceMail());
});



Route::get('/test', function () {
    return view ('test');
});

require __DIR__.'/auth.php';
