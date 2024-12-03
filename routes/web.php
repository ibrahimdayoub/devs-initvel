<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;
use Devs\Initvel\Helpers\Main;

// Response cache middleware group (Comment out during development)
Route::middleware('response.cache')->group(function () {
    // Language redirection routes
    Route::get('/contact', function () {
        return redirect('/en/contact');
    });
    Route::get('/about', function () {
        return redirect('/en/about');
    });
    Route::get('/', function () {
        return redirect('/en');
    });

    // Language specific pages
    Route::prefix('{lang}')->group(function () {
        Route::get('/contact', [DataController::class, 'contact'])->name('contact');
        Route::get('/about', [DataController::class, 'about'])->name('about');
        Route::get('/', [DataController::class, 'home'])->name('home');
    });

    // Change language
    Route::get('/change-lang/{lang}', function ($lang) {
        return Main::changeLang($lang);
    })->name('change-lang');
});