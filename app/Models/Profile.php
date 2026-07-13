<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'bio',
        'email',
        'whatsapp',
        'location',
        'github_url',
        'linkedin_url',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'resume_url',
        'avatar_initials',
        'avatar_path',
    ];
}
