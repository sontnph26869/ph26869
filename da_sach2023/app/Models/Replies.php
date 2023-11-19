<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\comment;
use Illuminate\Database\Eloquent\SoftDeletes;

class Replies extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['comment_id','user_id','message','parent_id'];
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
    public function comment()
    {
        return $this->belongsTo(comment::class, 'comment_id');
    }

    public function replies()
    {
        return $this->hasMany(Replies::class, 'parent_id');
    }
    
}
