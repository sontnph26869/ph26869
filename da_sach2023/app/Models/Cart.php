<?php

namespace App\Models;
use App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'book_id', 'quantily'];

    public function book()
    {
        return $this->belongsTo(Book::class,'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}