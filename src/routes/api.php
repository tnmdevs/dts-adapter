<?php


use Illuminate\Support\Facades\Route;
use TNM\DTS\Http\Controllers\TransactionCallbackController;

Route::post('callback/{transaction}', TransactionCallbackController::class);