<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Genre;
use App\Models\BookGenre;


class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'books';
    public $timestamps = true;
    protected $fillable = ['name', 'slug', 'language', 'poster', 'author', 'price', 'quantily', 'view', 'description',  'status'];
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }
    public function book_genres()
    {
        return $this->hasMany(BookGenre::class, 'book_id');
    }

}
