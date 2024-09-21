<?php

use Illuminate\Support\Facades\Route;
use samueltarus\LaravelPesaPal\Http\Controllers\PesaPalController;

Route::group(['prefix' => 'pesapal', 'middleware' => ['web']], function () {
    Route::post('process-payment', [PesaPalController::class, 'processPayment'])->name('pesapal.process-payment');
    Route::get('check-status', [PesaPalController::class, 'checkStatus'])->name('pesapal.check-status');
});