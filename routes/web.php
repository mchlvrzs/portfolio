<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactInboxController;
use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Private contact-message inbox (requires INBOX_PASSWORD)
Route::get('/inbox', [ContactInboxController::class, 'index'])->name('inbox.index');
Route::post('/inbox/login', [ContactInboxController::class, 'login'])->name('inbox.login');
Route::post('/inbox/logout', [ContactInboxController::class, 'logout'])->name('inbox.logout');
Route::post('/inbox/{message}/read', [ContactInboxController::class, 'markRead'])->name('inbox.read');
