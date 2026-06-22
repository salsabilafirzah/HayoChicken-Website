<?php

use Illuminate\Support\Facades\Route;

// Livewire Settings Routes Removed for Consistency
// Users now use the custom profile page at /profile

/* @chisel-passkeys */
Route::get('.well-known/passkey-endpoints', function () {
    return response()->json([
        'enroll' => route('profile'),
        'manage' => route('profile'),
    ]);
})->name('well-known.passkeys');
/* @end-chisel-passkeys */
