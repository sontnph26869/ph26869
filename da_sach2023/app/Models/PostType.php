<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class PostType extends Model
{
    use HasFactory, NodeTrait, SoftDeletes;
    public $timestamps = true;
    public $table = 'post_types';
    public $fillable = ['name', 'slug', 'image', 'parent_id', 'description', 'status'];

}
