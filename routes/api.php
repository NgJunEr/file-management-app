<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrController;


Route::get('/prs', function() {
    return App\Models\Pr::with(['supplier', 'customer', 'products'])->get();
});