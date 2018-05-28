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

Route::get('/', array('as' => 'make-manifest', 'uses' => 'FileController@makeManifest'));

Route::get('import-excel', array('uses' => 'FileController@importExportExcelORCSV'));
Route::get('import-customers', array('as' => 'import-customers', 'uses' => 'FileController@importCustomersIntoDB'));
Route::get('import-products', array('as' => 'import-products', 'uses' => 'FileController@importProductsIntoDB'));
Route::get('import-invoice', array('as' => 'import-invoice', 'uses' => 'FileController@importInvoiceIntoDB'));
Route::get('import-units', array('as' => 'import-units', 'uses' => 'FileController@importUnitsIntoDB'));
Route::get('import-contacts', array('as' => 'import-contacts', 'uses' => 'FileController@importContactsIntoDB'));

Route::get('invoice', array('as' => 'invoice', 'uses' => 'FileController@testInvoice'));

Route::get('download-excel-file/{type}', array('as' => 'einvoicexcel-file', 'uses' => 'FileController@downloadExcelFile'));

Route::resource('vehicles', 'VehicleController');
Route::resource('drivers', 'DriverController');
Route::resource('businesses', 'BusinessController');