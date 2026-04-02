<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['domain_id', 'name', 'description', 'contact_phone', 'contact_email', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'assigned_team_id');
    }
}
