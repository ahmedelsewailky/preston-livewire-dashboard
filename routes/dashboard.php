<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalenderController;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "dashboard" middleware group. Make something great!
|
*/

Route::view('/', 'dashboard')
    ->name('dashboard');

Route::view('profile', 'profile')
    ->name('profile');

Volt::route('category', 'category')
    ->name('category');

Volt::route('tag', 'tag')
    ->name('tag');

Volt::route('permission', 'permission')
    ->name('permission');

Volt::route('messenger', 'messenger')
    ->name('messenger');

Route::get('calendar', [CalenderController::class, 'index'])
    ->name('calendar');

Route::post('calendar-crud-ajax', [CalenderController::class, 'calendarEvents']);

Route::group(['prefix' => 'role', 'as' => 'role.'], function() {
    Volt::route('/', 'roles.role-list')
        ->name('index');

    Volt::route('create', 'roles.create-role-form')
        ->name('create');

    Volt::route('{role}/edit', 'roles.update-role-form')
        ->name('update');
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
    Volt::route('/', 'users.users-list')
        ->name('index');

    Volt::route('create', 'users.create-user-form')
        ->name('create');

    Volt::route('{user}/edit', 'users.update-user-form')
        ->name('update');
});

Route::group(['prefix' => 'posts', 'as' => 'posts.'], function() {
    Volt::route('/', 'posts.posts-list')
        ->name('index');

    Volt::route('create', 'posts.create-post-form')
        ->name('create');

    Volt::route('{post}/edit', 'posts.update-post-form')
        ->name('update');
});

Route::group(['prefix' => 'notepad', 'as' => 'notepad.'], function() {
    Volt::route('/', 'notepad.notepad-list')
        ->name('index');

    Volt::route('create', 'notepad.create-note-form')
        ->name('create');

    Volt::route('{notepad}/edit', 'notepad.edit-note-form')
        ->name('edit');
});
