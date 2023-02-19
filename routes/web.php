<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardConroller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoicesDetailesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('checkUser')->group(function () {

    Route::get('dashboard', function () {
        return view('dashboard');
    });


    Route::resources([

        'invoices' => InvoiceController::class,
        'sections' => SectionController::class,
        'products' => ProductController::class,
        'invoice-detailes' => InvoicesDetailesController::class,
        'invoice-attachments' => InvoicesAttachmentsController::class,
    ]);


    Route::controller(InvoiceController::class)->group(function () {

        Route::get('all-invoices',  'index')->name('all_Invoices');
        Route::get('all-invoices-unpaid',  'invoice_Unpaid')->name('invoices_unpaid');
        Route::get('all-invoices-paid',  'invoice_Paid')->name('invoices_paid');
        Route::get('all-invoices-partial-paid',  'invoice_Partial')->name('invoices_partial_paid');
        Route::get('invoice/status-show/{id}',  'statusShow')->name('statusShow');
        Route::put('invoice/{id}/update',  'update')->name('update');
        Route::put('invoice/{id}/change-status',  'updateStatus')->name('updateStatus');
        Route::delete('invoice/delete',  'destroy')->name('deleteInvoice');

        Route::get('invoices-Paid',  'invoice_Paid')->name('invoicePaid');
        Route::get('invoices-unPaid',  'invoice_Unpaid')->name('invoiceUnpaid');
        Route::get('invoices-Partial',  'invoice_Partial')->name('invoicePartial');
        Route::get('print-invoice/{id}',  'printInvoice')->name('printInvoice');
        Route::get('print/{id}',  'print')->name('print');

        Route::get('invoice/export',  'export')->name('export');
        Route::get('mark-all-invoices-read',  'MarkAllRead')->name('markAllRead');
    });

    Route::controller(InvoicesDetailesController::class)->group(function () {

        Route::get('invoice-detailes/{id}', 'show')->name('detailes');
        Route::get('View_file/{invoice_number}/{file_name}', 'openFile');
        Route::get('download/{invoice_number}/{file_name}', 'getFile');
        Route::post('delete_file', 'destroy')->name('delete_file');
    });

    Route::controller(InvoiceArchiveController::class)->group(function () {

        Route::get('invoices-archive', 'index')->name('invoiceArchive');
        Route::delete('invoice-archive', 'destroy')->name('makeArchive');
        Route::post('invoice-restore', 'restoreInvoice')->name('restoreInvoice');
        Route::delete('invoice-delete', 'deleteInvoice')->name('deleteArchive');
    });

    Route::controller(InvoiceReportController::class)->group(function () {

        Route::get('invoices-report', 'index')->name('reports');
        Route::get('clients-report', 'create_customer_report')->name('clients_reports');
        Route::post('search-invoices', 'SearchInvoices')->name('Search_invoices');
        Route::post('customer-reports', 'CustomerSearch')->name('customer');
    });

    Route::group(['middleware' => ['auth']], function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('users', 'index');
            Route::get('user-create', 'create')->name('create_user');
            Route::get('user-edit/{id}', 'edit')->name('edit_user');
            Route::delete('user-destroy', 'destroy')->name('destroy_user');
            Route::post('user-store', 'store')->name('user_store');
            Route::post('user-update/{id}', 'update')->name('user_update');
        });

        Route::controller(RoleController::class)->group(function () {
            Route::get('roles', 'index');
            Route::get('role-show/{id}', 'show')->name('show_role');
            Route::get('role-edit/{id}', 'edit')->name('edit_role');
            Route::get('role-create', 'create')->name('create_role');
            Route::post('role-store', 'store')->name('store_role');
            Route::post('role-update/{id}', 'update')->name('update_role');
            Route::delete('role-destroy/{id}', 'destroy')->name('destroy_role');
        });
    });
});

require __DIR__ . '/auth.php';

Route::controller(AdminController::class)->group(function () {
    Route::get('/{page}', 'index');
});