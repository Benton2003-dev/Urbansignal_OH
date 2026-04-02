<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Domain extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'color', 'icon', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($domain) {
            if (empty($domain->slug)) {
                $domain->slug = Str::slug($domain->name);
            }
        });
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
