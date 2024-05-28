<?php

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

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Modules\Quotation\Http\Controllers\QuotationController;

Route::prefix('quotation')->group(function() {
    Route::get('/', 'QuotationController@index');
});


Route::group(['middleware' => 'PlanModuleCheck:Quotation'], function ()
{
    Route::resource('quotation', QuotationController::class);
    Route::get('quotation/create/{cid}', [QuotationController::class, 'create'])->name('quotation.create');
    Route::post('quotation/product', [QuotationController::class, 'product'])->name('quotation.product');
    Route::post('quantity/product', [QuotationController::class, 'productQuantity'])->name('product.quantity');
    Route::get('items/quotations', [QuotationController::class, 'items'])->name('quotation.items');
    Route::post('quotation/section/type', [QuotationController::class,'QuotationSectionGet'])->name('quotation.section.type');
    Route::post('quotation/product/destroy', [QuotationController::class, 'productDestroy'])->name('quotation.product.destroy');
    Route::get('invoice/create/{quotation}', [InvoiceController::class, 'create'])->name('quotation.convert.invoice');


    // quotation template settig in account
    Route::get('/quotation/preview/{template}/{color}', [QuotationController::class,'previewQuotation'])->name('quotation.preview');
    Route::post('/quotation/template/setting/store', [QuotationController::class,'saveQuotationTemplateSettings'])->name('quotation.template.setting');
});

// proposal
Route::get('/quotation/pay/{quotation}', [QuotationController::class, 'payquotation'])->name('pay.quotationpay');
Route::get('quotation/pdf/{id}', [QuotationController::class, 'quotation'])->name('quotation.pdf');
