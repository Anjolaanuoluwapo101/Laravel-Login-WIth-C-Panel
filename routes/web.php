<?php

use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\BecomeAdmin;
use Livewire\Livewire;
use App\Livewire\ServicesPanel;
use App\Http\Controllers\AdminLoginController;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Livewire::component('become-admin', BecomeAdmin::class);
Route::get('/become-admin', BecomeAdmin::class)
    ->middleware(['auth', 'verified'])
    ->name('become-admin');



Route::view('admin', 'admin-login')->name('admin.login');

Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::view('admin/dashboard', 'admin-dashboard')
    ->middleware(['auth', 'verified', AdminMiddleware::class])
    ->name('admin-panel');

Route::get('/services', ServicesPanel::class)->middleware(['auth', 'verified',AdminMiddleware::class])->name('services.panel');


Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
