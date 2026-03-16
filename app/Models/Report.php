<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'category_id',
        'arrondissement_id',
        'title',
        'description',
        'latitude',
        'longitude',
        'address',
        'status',
        'priority',
        'assigned_team_id',
        'assigned_by',
        'agent_notes',
        'resolved_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'resolved_at' => 'datetime',
    ];

    // Status labels
    public static array $statusLabels = [
        'submitted'   => 'Soumis',
        'validated'   => 'Validé',
        'in_progress' => 'En cours',
        'resolved'    => 'Résolu',
        'archived'    => 'Archivé',
    ];

    // Priority labels
    public static array $priorityLabels = [
        'low'    => 'Faible',
        'medium' => 'Moyen',
        'high'   => 'Élevé',
        'urgent' => 'Urgent',
    ];

    public static array $statusColors = [
        'submitted'   => 'gray',
        'validated'   => 'blue',
        'in_progress' => 'yellow',
        'resolved'    => 'green',
        'archived'    => 'slate',
    ];

    public static array $priorityColors = [
        'low'    => 'green',
        'medium' => 'yellow',
        'high'   => 'orange',
        'urgent' => 'red',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? $this->status;
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::$priorityLabels[$this->priority] ?? $this->priority;
    }

    public function getStatusColorAttribute(): string
    {
        return self::$statusColors[$this->status] ?? 'gray';
    }

    public function getPriorityColorAttribute(): string
    {
        return self::$priorityColors[$this->priority] ?? 'gray';
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function arrondissement()
    {
        return $this->belongsTo(Arrondissement::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'assigned_team_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function photos()
    {
        return $this->hasMany(ReportPhoto::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(ReportStatusHistory::class)->orderBy('created_at');
    }
}
