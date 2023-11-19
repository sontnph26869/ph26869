<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_Type_Post extends Model
{
    use HasFactory;
    protected $fillable=['post_id','post_type'];

    protected $table="post_type_post";
}
