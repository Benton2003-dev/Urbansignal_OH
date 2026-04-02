<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Arrondissement;
use App\Models\Category;
use App\Models\Domain;
use App\Models\Report;
use App\Models\ReportPhoto;
use App\Models\ReportStatusHistory;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function create()
    {
        $domains         = Domain::where('is_active', true)->orderBy('name')->get();
        $arrondissements = Arrondissement::where('is_active', true)->orderBy('name')->get();

        return view('citizen.reports.create', compact('domains', 'arrondissements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'domain_id'         => 'required|exists:domains,id',
            'category_id'       => 'required|exists:categories,id',
            'arrondissement_id' => 'required|exists:arrondissements,id',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string|max:2000',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'address'           => 'nullable|string|max:500',
            'photos'            => 'nullable|array|max:5',
            'photos.*'          => 'image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $report = Report::create([
                'ticket_number'     => TicketService::generate(),
                'user_id'           => auth()->id(),
                'domain_id'         => $validated['domain_id'],
                'category_id'       => $validated['category_id'],
                'arrondissement_id' => $validated['arrondissement_id'],
                'title'             => $validated['title'],
                'description'       => $validated['description'],
                'latitude'          => $validated['latitude'] ?? null,
                'longitude'         => $validated['longitude'] ?? null,
                'address'           => $validated['address'] ?? null,
                'status'            => 'submitted',
                'priority'          => 'medium',
            ]);

            // Photos upload
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('reports/' . $report->id, 'public');
                    ReportPhoto::create([
                        'report_id'     => $report->id,
                        'path'          => $path,
                        'original_name' => $photo->getClientOriginalName(),
                        'size'          => $photo->getSize(),
                    ]);
                }
            }

            // Initial status history
            ReportStatusHistory::create([
                'report_id'  => $report->id,
                'old_status' => null,
                'new_status' => 'submitted',
                'changed_by' => auth()->id(),
                'comment'    => 'Signalement créé par le citoyen.',
            ]);

            session(['last_ticket' => $report->ticket_number]);
        });

        return redirect()->route('citizen.reports.success')
            ->with('success', 'Votre signalement a été soumis avec succès.');
    }

    public function success()
    {
        $ticket = session('last_ticket');
        if (!$ticket) {
            return redirect()->route('citizen.dashboard');
        }
        $report = Report::with(['category', 'arrondissement'])
            ->where('ticket_number', $ticket)
            ->firstOrFail();

        return view('citizen.reports.success', compact('report'));
    }

    public function show(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403);
        }

        $report->load(['category', 'arrondissement', 'team', 'statusHistories.changedBy', 'photos']);

        return view('citizen.reports.show', compact('report'));
    }
}
