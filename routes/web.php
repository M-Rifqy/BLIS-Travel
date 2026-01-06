<?php

use Illuminate\Support\Facades\Route;

// Auth
use App\Http\Controllers\Auth\AuthController;

// Admin
use App\Http\Controllers\Admin\Gallery\GalleryController;
use App\Http\Controllers\Admin\Activity\ActivityController;
use App\Http\Controllers\Admin\Document\DocumentController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Attendance\AttendanceController;
use App\Http\Controllers\Admin\Participant\ParticipantController;
use App\Http\Controllers\Admin\Participant\ParticipantDocumentController;
// Client
use App\Http\Controllers\Client\Activity\ActivityController as ClientActivityController;
use App\Http\Controllers\Client\Attendance\AttendanceController as ClientAttendanceController;
use App\Http\Controllers\Client\Dashboard\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\Document\DocumentController as ClientDocumentController;
use App\Http\Controllers\Client\Gallery\GalleryController as ClientGalleryController;
use App\Http\Controllers\Client\Home\HomeController;
use App\Http\Controllers\Client\Profile\ProfileController;

//Landing Page
Route::name('client.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
    });

//Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('login');
    Route::post('/login', [AuthController::class, 'store']);
});

Route::middleware('auth')->post('/logout', [AuthController::class, 'destroy'])->name('logout');

// Admin
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('index');

        // Activities
        Route::prefix('activity')
            ->name('activity.')
            ->group(function () {
                Route::get('/', [ActivityController::class, 'index'])->name('index');
                Route::post('/', [ActivityController::class, 'store'])->name('store');
                Route::get('/{activity}', [ActivityController::class, 'show'])->name('show');
                Route::put('/{activity}', [ActivityController::class, 'update'])->name('update');
                Route::delete('/{activity}', [ActivityController::class, 'destroy'])->name('destroy');

                Route::prefix('{activity}/participant')
                    ->name('participant.')
                    ->group(function () {
                        Route::get('/', [ParticipantController::class, 'index'])->name('index');
                        Route::post('/', [ParticipantController::class, 'store'])->name('store');
                        Route::put('/{participant}', [ParticipantController::class, 'update'])->name('update');
                        Route::delete('/{participant}', [ParticipantController::class, 'destroy'])->name('destroy');
                        Route::get('/{participant}/qrcode', [ParticipantController::class, 'downloadQr'])
                            ->name('download-qr');
                        Route::post('/{participant}/reset-password', [ParticipantController::class, 'resetPassword'])->name('reset-password');

                        Route::prefix('{participant}/document')
                            ->name('document.')
                            ->group(function () {
                                Route::get('/', [ParticipantDocumentController::class, 'index'])->name('index');
                                Route::post('/', [ParticipantDocumentController::class, 'store'])->name('store');
                                Route::put('/{document}', [ParticipantDocumentController::class, 'update'])->name('update');
                                Route::delete('/{document}', [ParticipantDocumentController::class, 'destroy'])->name('destroy');
                            });
                    });

                Route::prefix('{activity}/attendance')
                    ->name('attendance.')
                    ->group(function () {
                        Route::get('/', [AttendanceController::class, 'index'])->name('index');
                        Route::post('/scan', [AttendanceController::class, 'scan'])->name('scan');
                    });

                Route::prefix('{activity}/document')
                    ->name('document.')
                    ->group(function () {
                        Route::get('/', [DocumentController::class, 'index'])->name('index');
                        Route::post('/', [DocumentController::class, 'store'])->name('store');
                        Route::put('/{document}', [DocumentController::class, 'update'])->name('update');
                        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');
                    });

                Route::prefix('{activity}/gallery')
                    ->name('gallery.')
                    ->group(function () {
                        Route::get('/', [GalleryController::class, 'index'])->name('index');
                        Route::post('/', [GalleryController::class, 'store'])->name('store');
                        Route::put('/{gallery}', [GalleryController::class, 'update'])->name('update');
                        Route::delete('/{gallery}', [GalleryController::class, 'destroy'])->name('destroy');
                    });
            });
    });


    // Client
Route::prefix('client')
    ->name('client.')
    ->middleware(['auth', 'role:client'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('index');

        // Profil
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

        // Kegiatan (untuk lihat detail + relasi)
        Route::prefix('activity')
            ->name('activity.')
            ->group(function () {

                Route::get('/{activity}', [ClientActivityController::class, 'index'])->name('show');

                Route::get('/{activity}/attendance', [ClientAttendanceController::class, 'index'])
                    ->name('attendance');

                Route::get('/{activity}/document', [ClientDocumentController::class, 'index'])
                    ->name('document');

                Route::get('/{activity}/gallery', [ClientGalleryController::class, 'index'])
                    ->name('gallery');
            });
    });
