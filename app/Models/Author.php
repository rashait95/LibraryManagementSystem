<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'country',
    ];

    public function books(){
        return $this->hasMany(Book::class);
    }


    public function reviews(){
        return $this->morphMany(Review::class,'reviewable');
        }
}
