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
 
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' =>  'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], 
function(){
    
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function(){
    
    Route::get('/','dashboardcontroller@index')->name('index');
    Route::resource('/users','usercontroller')->except('show') ;
    Route::resource('/categories','categorycontroller')->except('show') ;
    Route::resource('/products','productcontroller')->except('show') ;
    Route::resource('/clients','clientcontroller')->except('show') ;
    Route::resource('/clients.order','client\ordercontroller')->except('show') ;
    Route::resource('/orders','ordercontroller')->except('show') ;
    Route::get('/orders/{order}/products','ordercontroller@products')->name('order.products');
    Route::delete('/orders/{order}/destroy','ordercontroller@destroy')->name('order.destroy');
  //  Route::get('/orders/{order}/edit','ordercontroller@edit')->name('order.edit');
});


});