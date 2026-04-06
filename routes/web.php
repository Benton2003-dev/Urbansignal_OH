<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Citizen;
use App\Http\Controllers\Agent;
use App\Http\Controllers\Admin;
use App\Http\Controllers\SuperAdmin\SuperadminController;
use App\Http\Controllers\ProfileController;
use App\Models\Domain;
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

    // Domains
    Route::resource('domaines', Admin\DomainController::class)->names('domains')->parameters(['domaines' => 'domain']);

    // Categories
    Route::resource('categories', Admin\CategoryController::class);

    // Teams
    Route::resource('equipes', Admin\TeamController::class)->names('teams')->parameters(['equipes' => 'team']);

    // Reports
    Route::get('/signalements', [Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/signalements/statistiques', [Admin\ReportController::class, 'statistics'])->name('reports.statistics');
    Route::get('/signalements/{report}', [Admin\ReportController::class, 'show'])->name('reports.show');
});

// ─── API interne : catégories par domaine ────────────────────────────────────
Route::get('/api/domaines/{domain}/categories', function (Domain $domain) {
    return response()->json(
        $domain->categories()->where('is_active', true)->orderBy('name')->get(['id', 'name', 'color'])
    );
})->middleware('auth')->name('api.domain.categories');

// ─── Super Admin routes ───────────────────────────────────────────────────────
Route::prefix('superadmin')->middleware(['auth', 'superadmin'])->name('superadmin.')->group(function () {
    Route::get('/dashboard',                          [SuperadminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users',                              [SuperadminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/promote',             [SuperadminController::class, 'promoteUser'])->name('users.promote');
    Route::post('/users/{user}/reset-password',       [SuperadminController::class, 'resetUserPassword'])->name('users.reset-password');
    Route::post('/users/{user}/ban',                  [SuperadminController::class, 'toggleUserBan'])->name('users.ban');
    Route::get('/maintenance',                        [SuperadminController::class, 'maintenance'])->name('maintenance');
    Route::post('/maintenance/toggle',                [SuperadminController::class, 'toggleMaintenance'])->name('maintenance.toggle');
    Route::post('/cache/clear',                       [SuperadminController::class, 'clearCache'])->name('cache.clear');
    Route::get('/settings',                           [SuperadminController::class, 'settings'])->name('settings');
    Route::post('/settings',                          [SuperadminController::class, 'updateSettings'])->name('settings.update');
    Route::get('/export/users',                       [SuperadminController::class, 'exportUsers'])->name('export.users');
    Route::get('/export/reports',                     [SuperadminController::class, 'exportReports'])->name('export.reports');
});

// ─── Smart redirect after login ──────────────────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    return match ($user->role) {
        'superadmin' => redirect()->route('superadmin.dashboard'),
        'admin'      => redirect()->route('admin.dashboard'),
        'agent'      => redirect()->route('agent.dashboard'),
        default      => redirect()->route('citizen.dashboard'),
    };
})->middleware('auth')->name('dashboard');
