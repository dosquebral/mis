<?php

use App\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::get('/', User::class);
Route::view('/profile', 'User.profile');