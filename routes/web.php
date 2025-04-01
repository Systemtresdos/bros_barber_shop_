<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

use Illuminate\Http\Request;
use App\Http\Controllers\CrudController;

Route::get('/crud', function (Request $request) {
    return CrudController::index($request);
});
Route::post('/crud/crear', function (Request $request) {
    return CrudController::create($request);
});
Route::post('/crud/editar', function (Request $request) {
    return CrudController::edit($request);
});
Route::post('/crud/eliminar', function (Request $request) {
    return CrudController::delete($request);
});


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function() {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
         ->except(['show', 'destroy']);
});