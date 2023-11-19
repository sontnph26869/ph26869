<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['image_url','alt_text','status'];
    protected $casts = [
        'image_urls' => 'json'
    ];
}
