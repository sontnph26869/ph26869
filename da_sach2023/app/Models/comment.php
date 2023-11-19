<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Post;
use App\Models\Replies;


class comment extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['user_id','post_id','message'];
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
    public function post(){
        return $this->belongsTo(Post::class ,'post_id');
    }
    public function replies()
{
    return $this->hasMany(Replies::class,'comment_id')->whereNull('parent_id');
}


}
