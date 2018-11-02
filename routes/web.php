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
Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function(){
	//ADMIN
	Route::get('/', 'AdminController@index')->name('admin');

	//SALDO
	Route::get('balance', 'BalanceController@index')->name('balance');

	//RECARREGAR
	Route::get('balance/deposit', 'BalanceController@deposit')->name('balance.deposit');

	//INSERIR RECARGA
	Route::post('balance/deposit', 'BalanceController@depositStore')->name('deposit.store');

	//SACAR
	Route::get('withdraw', 'BalanceController@withdraw')->name('balance.withdraw');

	//REALIZAR SAQUE
	Route::post('withdraw', 'BalanceController@withdrawStore')->name('withdraw.store');

	//TRANSFERENCIA
	Route::get('transfer', 'BalanceController@transfer')->name('balance.transfer');

	//CONFIRMAR TRANSFERENCIA
	Route::post('confirm-transfer', 'BalanceController@transferConfirm')->name('transfer.confirm');

	//REALIZAR TRANSFERENCIA
	Route::post('transfer', 'BalanceController@transferStore')->name('transfer.store');

	//HISTORICO
	Route::get('historic', 'BalanceController@historic')->name('admin.historic');

	//FILTRO HISTORICO
	Route::any('historic', 'BalanceController@searchHistoric')->name('historic.search');

});

Route::get('perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');

Route::post('atualizar-perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');

Auth::routes();

