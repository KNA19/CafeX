<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', 'HomeController@index')->name('rooturl');
Route::get('/admin/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('/admin/items', 'ItemController@items')->name('items');
Route::post('/admin/item/save', 'ItemController@saveitem')->name('saveItem');
Route::post('/admin/item/edit', 'ItemController@edititem')->name('editItem');
Route::post('/admin/item/delete', 'ItemController@deleteitem')->name('deleteItem');

Route::get('/admin/makeorder', 'OrderController@makeorder')->name('makeOrder');
Route::post('/admin/makeorder/draft', 'OrderController@makedraft')->name('makeDraft');
Route::post('/admin/makeorder/removeitem', 'OrderController@removeitem')->name('removeItem');
Route::get('/admin/makeorder/{invno}', 'OrderController@addorder')->name('addOrder');

Route::post('/admin/order/confirm', 'OrderController@confirmorder')->name('confirmOrder');
Route::get('/admin/order/confirm/list', 'OrderController@confirmlist')->name('confirmList');

Route::get('/admin/printcopy/{invno}', 'OrderController@printcopy')->name('printCopy');


Route::get('/admin/account', 'AccountController@account')->name('account');
Route::get('/admin/account/{date}', 'AccountController@account')->name('accountDate');

Route::get('/admin/waiter', 'HomeController@waiterlist')->name('waiterlist');
Route::post('/admin/waiter/add', 'HomeController@addwaiter')->name('addWaiter');
Route::post('/admin/waiter/remove', 'HomeController@removewaiter')->name('removeWaiter');

// --------------- Customer Section ----------------
Route::get('/customer/dashboard', 'CustomerController@dashboard')->name('customer_dashboard');
Route::post('/customer/makedraft', 'CustomerController@makedraft')->name('customer_makedraft');
Route::post('/customer/removeitem', 'CustomerController@removeitem')->name('customer_removeitem');
Route::get('/customer/addorder/{invno}', 'CustomerController@addorder')->name('customer_addorder');
Route::post('/customer/confirmorder', 'CustomerController@confirmorder')->name('customer_confirmorder');
Route::get('/customer/pendingorders', 'CustomerController@pendingorder')->name('customer_pendingorder');
Route::get('/customer/printcopy/{invno}', 'CustomerController@printcopy')->name('customer_printcopy');

// --------------- Waiter Section ----------------
Route::get('/waiter/dashboard', 'WaiterController@dashboard')->name('waiter_dashboard');
Route::post('/waiter/confirm', 'WaiterController@confirm')->name('waiter_confirm');
