<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'tech_stack',
        'live_url',
        'github_url',
        'image_gradient',
        'image_path',
        'featured',
        'category',
        'sort_order',
    ];

    protected $casts = [
        'tech_stack' => 'array',
        'featured' => 'boolean',
        'sort_order' => 'integer',
    ];
}
