<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Citizen;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Admin;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public routes ──────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/suivre', [HomeController::class, 'track'])->name('track');

// ─── Auth routes (Breeze) ────────────────────────────────────────────────────
require __DIR__.'/auth.php';

// ─── Profile (Breeze default) ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Citizen routes ──────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:citizen,agent,admin'])->prefix('citoyen')->name('citizen.')->group(function () {
    Route::get('/tableau-de-bord', [Citizen\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/signalements/nouveau', [Citizen\ReportController::class, 'create'])->name('reports.create');
    Route::post('/signalements', [Citizen\ReportController::class, 'store'])->name('reports.store');
    Route::get('/signalements/succes', [Citizen\ReportController::class, 'success'])->name('reports.success');
    Route::get('/signalements/{report}', [Citizen\ReportController::class, 'show'])->name('reports.show');
});

// ─── Agent routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:agent,admin'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/tableau-de-bord', [Agent\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/signalements', [Agent\ReportController::class, 'index'])->name('reports.index');
    Route::get('/signalements/carte', [Agent\ReportController::class, 'map'])->name('reports.map');
    Route::get('/signalements/{report}', [Agent\ReportController::class, 'show'])->name('reports.show');
    Route::patch('/signalements/{report}/statut', [Agent\ReportController::class, 'updateStatus'])->name('reports.status');
    Route::patch('/signalements/{report}/equipe', [Agent\ReportController::class, 'assignTeam'])->name('reports.assign');
});

// ─── Admin routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('utilisateurs', Admin\UserController::class)->names('users')->parameters(['utilisateurs' => 'user']);
    Route::patch('/utilisateurs/{user}/statut', [Admin\UserController::class, 'toggleStatus'])->name('users.toggle');

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Reports
    Route::get('/signalements', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/signalements/statistiques', [Admin\ReportController::class, 'statistics'])->name('reports.statistics');
    Route::get('/signalements/{report}', [Admin\ReportController::class, 'show'])->name('reports.show');
});

// ─── Smart redirect after login ──────────────────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'admin'   => redirect()->route('admin.dashboard'),
        'agent'   => redirect()->route('agent.dashboard'),
        default   => redirect()->route('citizen.dashboard'),
    };
})->middleware('auth')->name('dashboard');
