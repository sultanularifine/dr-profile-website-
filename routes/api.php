<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\SslCommerzController;
Route::post('/sslcommerz/ipn', [SslCommerzController::class, 'ipn'])->name('sslcommerz.ipn');
