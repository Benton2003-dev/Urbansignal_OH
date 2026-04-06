<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    // ─── Dashboard ────────────────────────────────────────────────────────────

    public function dashboard()
    {
        $stats = [
            'total_users'    => User::where('role', '!=', 'superadmin')->count(),
            'total_reports'  => Report::count(),
            'total_admins'   => User::where('role', 'admin')->count(),
            'total_agents'   => User::where('role', 'agent')->count(),
            'total_citizens' => User::where('role', 'citizen')->count(),
            'reports_today'  => Report::whereDate('created_at', today())->count(),
            'pending'        => Report::where('status', 'submitted')->count(),
            'resolved'       => Report::where('status', 'resolved')->count(),
        ];

        $recentUsers = User::where('role', '!=', 'superadmin')
            ->latest()
            ->take(8)
            ->get();

        $recentReports = Report::with(['user', 'category'])
            ->latest()
            ->take(8)
            ->get();

        // Dernières lignes du log Laravel
        $logLines = $this->getRecentLogs(20);

        // Infos système
        $systemInfo = [
            'php_version'    => PHP_VERSION,
            'laravel_version'=> app()->version(),
            'environment'    => app()->environment(),
            'debug_mode'     => config('app.debug') ? 'Activé ⚠️' : 'Désactivé ✓',
            'cache_driver'   => config('cache.default'),
            'queue_driver'   => config('queue.default'),
            'db_driver'      => config('database.default'),
            'maintenance'    => app()->isDownForMaintenance() ? 'En maintenance' : 'En ligne',
        ];

        return view('superadmin.dashboard', compact(
            'stats', 'recentUsers', 'recentReports', 'logLines', 'systemInfo'
        ));
    }

    // ─── Gestion des utilisateurs ─────────────────────────────────────────────

    public function users(Request $request)
    {
        $query = User::where('role', '!=', 'superadmin')->latest();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(20)->withQueryString();

        return view('superadmin.users', compact('users'));
    }

    public function promoteUser(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:citizen,agent,admin',
        ]);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Impossible de modifier le Super Admin.');
        }

        $oldRole = $user->role;
        $user->update(['role' => $request->role]);

        $this->logAction("Rôle de {$user->name} changé de {$oldRole} → {$request->role}");

        return back()->with('success', "Rôle de {$user->name} mis à jour en \"{$request->role}\".");
    }

    public function resetUserPassword(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Impossible de modifier le Super Admin.');
        }

        $newPassword = \Str::random(12);
        $user->update(['password' => Hash::make($newPassword)]);

        $this->logAction("Mot de passe réinitialisé pour {$user->name} ({$user->email})");

        return back()->with('success', "Nouveau mot de passe pour {$user->name} : {$newPassword} — Communiquez-le de manière sécurisée.");
    }

    public function toggleUserBan(User $user)
    {
        if ($user->role === 'superadmin') {
            return back()->with('error', 'Impossible de modifier le Super Admin.');
        }

        // Utilise le champ email_verified_at comme proxy de ban (null = banni)
        if ($user->email_verified_at) {
            $user->update(['email_verified_at' => null]);
            $msg = "{$user->name} a été suspendu.";
        } else {
            $user->update(['email_verified_at' => now()]);
            $msg = "{$user->name} a été réactivé.";
        }

        $this->logAction($msg);
        return back()->with('success', $msg);
    }

    // ─── Maintenance & Cache ──────────────────────────────────────────────────

    public function maintenance()
    {
        $logLines   = $this->getRecentLogs(50);
        $isMaintenance = app()->isDownForMaintenance();

        return view('superadmin.maintenance', compact('logLines', 'isMaintenance'));
    }

    public function toggleMaintenance(Request $request)
    {
        if (app()->isDownForMaintenance()) {
            Artisan::call('up');
            $msg = '✅ Plateforme remise en ligne.';
        } else {
            Artisan::call('down', [
                '--render' => 'errors.503',
                '--retry'  => 60,
                '--secret' => config('app.key'),
            ]);
            $msg = '🔧 Plateforme mise en maintenance.';
        }

        $this->logAction($msg);
        return back()->with('success', $msg);
    }

    public function clearCache(Request $request)
    {
        $type = $request->input('type', 'all');

        match ($type) {
            'config' => Artisan::call('config:clear'),
            'route'  => Artisan::call('route:clear'),
            'view'   => Artisan::call('view:clear'),
            'app'    => Cache::flush(),
            default  => $this->clearAllCaches(),
        };

        $this->logAction("Cache vidé : {$type}");
        return back()->with('success', "Cache \"{$type}\" vidé avec succès.");
    }

    // ─── Export données ───────────────────────────────────────────────────────

    public function exportUsers()
    {
        $users = User::where('role', '!=', 'superadmin')
            ->select('id', 'name', 'email', 'phone', 'role', 'created_at')
            ->get();

        $csv = "ID,Nom,Email,Téléphone,Rôle,Inscrit le\n";
        foreach ($users as $u) {
            $csv .= "\"{$u->id}\",\"{$u->name}\",\"{$u->email}\",\"{$u->phone}\",\"{$u->role}\",\"{$u->created_at}\"\n";
        }

        $this->logAction('Export utilisateurs CSV déclenché');

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="users_' . now()->format('Ymd_His') . '.csv"',
        ]);
    }

    public function exportReports()
    {
        $reports = Report::with(['user', 'category', 'arrondissement'])
            ->select('id', 'ticket_number', 'title', 'status', 'priority', 'user_id', 'category_id', 'arrondissement_id', 'created_at', 'resolved_at')
            ->get();

        $csv = "Ticket,Titre,Statut,Priorité,Citoyen,Catégorie,Arrondissement,Créé le,Résolu le\n";
        foreach ($reports as $r) {
            $csv .= "\"{$r->ticket_number}\",\"{$r->title}\",\"{$r->status}\",\"{$r->priority}\","
                  . "\"{$r->user->name}\",\"{$r->category->name}\",\"{$r->arrondissement->name}\","
                  . "\"{$r->created_at}\",\"{$r->resolved_at}\"\n";
        }

        $this->logAction('Export signalements CSV déclenché');

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reports_' . now()->format('Ymd_His') . '.csv"',
        ]);
    }

    // ─── Paramètres globaux ───────────────────────────────────────────────────

    public function settings()
    {
        return view('superadmin.settings');
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'app_name'    => 'required|string|max:100',
            'app_commune' => 'required|string|max:100',
            'app_email'   => 'required|email',
            'app_phone'   => 'nullable|string|max:20',
        ]);

        // Écriture dans .env (approche simple pour une app non containerisée)
        $this->setEnvValue('APP_NAME', '"' . $request->app_name . '"');
        $this->setEnvValue('APP_COMMUNE', '"' . $request->app_commune . '"');
        $this->setEnvValue('APP_EMAIL', $request->app_email);
        $this->setEnvValue('APP_PHONE', $request->app_phone ?? '');

        Artisan::call('config:clear');
        $this->logAction('Paramètres globaux mis à jour');

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    // ─── Helpers privés ───────────────────────────────────────────────────────

    private function getRecentLogs(int $lines = 30): array
    {
        $logPath = storage_path('logs/laravel.log');
        if (!File::exists($logPath)) return [];

        $content = File::get($logPath);
        $allLines = array_reverse(explode("\n", trim($content)));
        return array_slice(array_filter($allLines), 0, $lines);
    }

    private function clearAllCaches(): void
    {
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Cache::flush();
    }

    private function logAction(string $message): void
    {
        $user = auth()->user()->name ?? 'SuperAdmin';
        \Log::channel('single')->info("[SUPERADMIN] [{$user}] {$message}");
    }

    private function setEnvValue(string $key, string $value): void
    {
        $path    = base_path('.env');
        $content = File::get($path);

        if (preg_match("/^{$key}=/m", $content)) {
            $content = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $content);
        } else {
            $content .= "\n{$key}={$value}";
        }

        File::put($path, $content);
    }
}