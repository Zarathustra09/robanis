<?php

use App\Http\Controllers\LeadController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{service}', [PageController::class, 'service'])
    ->whereIn('service', array_keys(config('offerings')))
    ->name('services.show');
Route::get('/why-us', [PageController::class, 'whyUs'])->name('why-us');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Approach folded into the services page; About renamed to Why us.
Route::redirect('/approach', '/services#approach', 301);
Route::redirect('/about', '/why-us', 301);

Route::post('/leads', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('leads.store');
