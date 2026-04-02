<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['domain_id', 'name', 'slug', 'description', 'icon', 'color', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
