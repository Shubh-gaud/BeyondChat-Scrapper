<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'content',
        'source_url',
        'type',
        'references',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'references' => 'array',
    ];
}
