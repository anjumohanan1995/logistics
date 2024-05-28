<?php

use Illuminate\Support\Facades\Route;
use Modules\FreightManagementSystem\Http\Controllers\FreightManagementSystemController;
use Modules\FreightManagementSystem\Http\Controllers\PriceController;
use Modules\FreightManagementSystem\Http\Controllers\ContainerController;
use Modules\FreightManagementSystem\Http\Controllers\BookingRequestController;
use Modules\FreightManagementSystem\Http\Controllers\CustomerController;
use Modules\FreightManagementSystem\Http\Controllers\ShippingController;
use Modules\FreightManagementSystem\Http\Controllers\RouteController;
use Modules\FreightManagementSystem\Http\Controllers\ServiceController;
use Modules\FreightManagementSystem\Http\Controllers\ShippingInvoiceController;
use Modules\FreightManagementSystem\Http\Controllers\InvoicePaymentController;
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

Route::get('freight-management-system/booking-request/{slug}/{lang?}', [FreightManagementSystemController::class, 'booking'])->name('freight.booking.request');
Route::post('freight-management-system/booking-request/{slug}', [FreightManagementSystemController::class, 'store'])->name('freight.request.store');
Route::group(['middleware' => 'PlanModuleCheck:FreightManagementSystem'], function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::prefix('freightmanagementsystem')->group(function () {

            // Price 
            Route::resource('price', PriceController::class);
            Route::post('price/detail/{id}', [PriceController::class, 'detail'])->name('price.detail');

            //container
            Route::resource('container', ContainerController::class);
            Route::post('container/detail/{id}', [ContainerController::class, 'detail'])->name('container.detail');

            //booking request
            Route::resource('booking-request', BookingRequestController::class);
            Route::post('convert/cooking/to/shipping{id}', [BookingRequestController::class, 'convert'])->name('convert.cooking.to.shipping');
            Route::get('booking-request/manage/status/{id}/{status}', [BookingRequestController::class, 'manage_status'])->name('booking-request.manage.status');
            Route::any('booking-request/store/status/{id}/{status}', [BookingRequestController::class, 'store_status'])->name('booking-request.store.status');

            //customer
            Route::resource('customers', CustomerController::class);
            Route::resource('freight-invoice', ShippingInvoiceController::class);
            Route::any('invoice/save/{id}/', [ShippingInvoiceController::class, 'invoice_save'])->name('freight.invoice.save');
            //shipping
            Route::resource('shipping', ShippingController::class);
            Route::post('shipping/container/save/{id}', [ShippingController::class, 'shipping_container_save'])->name('shipping.container.save');
            Route::post('shipping/order/save/{id}', [ShippingController::class, 'shipping_order_save'])->name('shipping.order.save');
            Route::post('shipping/service/save/{id}', [ShippingController::class, 'shipping_service_save'])->name('shipping.service.save');
            Route::post('shipping/tracking/save/{id}', [ShippingController::class, 'shipping_tracking_save'])->name('shipping.tracking.save');
            Route::post('shipping/service/destroy', [ShippingController::class, 'serviceDestroy'])->name('shipping.service.destroy');
            Route::any('shipping/store/status/{id}/{status}', [ShippingController::class, 'store_status'])->name('shipping.store.status');

            //dashboard
            Route::get('dashboard', [FreightManagementSystemController::class, 'index'])->name('freight.dashboard');

            //route

            Route::get('route/create/{id}', [RouteController::class, 'create'])->name('route.create');
            Route::post('route/store/{id}', [RouteController::class, 'store'])->name('route.store');
            Route::delete('route/delete/{id}', [RouteController::class, 'destroy'])->name('route.destroy');
            Route::get('route/edit/{id}', [RouteController::class, 'edit'])->name('route.edit');
            Route::put('route/update/{id}', [RouteController::class, 'update'])->name('route.update');

            //service
            Route::resource('service', ServiceController::class);
            Route::post('service/detail/{id}', [ServiceController::class, 'detail'])->name('service.detail');
            //payment
            Route::get('freight-invoice/{id}/payment', [ShippingInvoiceController::class, 'payment'])->name('freight.invoice.payment');
            Route::post('freight-invoice/{id}/payment', [ShippingInvoiceController::class, 'createPayment'])->name('freight.invoice.payment');
            Route::DELETE('freight-invoice/{id}/payment/{pid}/', [ShippingInvoiceController::class, 'paymentDestroy'])->name('freight.invoice.payment.destroy');
        });
    });
});
