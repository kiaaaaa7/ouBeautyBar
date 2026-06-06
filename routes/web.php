<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DesignController::class, 'index'])->name('home');

require __DIR__.'/auth.php';

// Customer
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AppointmentController::class, 'dashboard'])->name('dashboard');
    Route::get('/booking/{design}', [AppointmentController::class, 'create'])->name('booking.create');
    Route::post('/booking', [AppointmentController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{id}', [AppointmentController::class, 'destroy'])->name('booking.destroy');
    Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');

    // Ambil slot tersedia (untuk form booking)
    Route::get('/slots-tersedia', [AppointmentController::class, 'slotsTersedia'])->name('slots.tersedia');
});

// Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // Customers
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers');

    // Appointments
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::patch('/appointments/{id}/status', [AdminController::class, 'updateStatus'])->name('appointments.status');
    Route::delete('/appointments/{id}', [AdminController::class, 'destroy'])->name('appointments.destroy');

    // Slot management
    Route::post('/slots', [AdminController::class, 'storeSlot'])->name('slots.store');
    Route::delete('/slots/{id}', [AdminController::class, 'destroySlot'])->name('slots.destroy');

    // Designs
    Route::get('/designs', [AdminController::class, 'designs'])->name('designs');
    Route::get('/designs/create', [AdminController::class, 'createDesign'])->name('designs.create');
    Route::post('/designs', [AdminController::class, 'storeDesign'])->name('designs.store');
    Route::get('/designs/{id}/edit', [AdminController::class, 'editDesign'])->name('designs.edit');
    Route::put('/designs/{id}', [AdminController::class, 'updateDesign'])->name('designs.update');
    Route::delete('/designs/{id}', [AdminController::class, 'destroyDesign'])->name('designs.destroy');
});