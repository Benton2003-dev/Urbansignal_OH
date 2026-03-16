<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportStatusHistory extends Model
{
    protected $fillable = ['report_id', 'old_status', 'new_status', 'changed_by', 'comment'];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getNewStatusLabelAttribute(): string
    {
        return Report::$statusLabels[$this->new_status] ?? $this->new_status;
    }

    public function getOldStatusLabelAttribute(): string
    {
        return Report::$statusLabels[$this->old_status] ?? $this->old_status ?? '—';
    }
}
