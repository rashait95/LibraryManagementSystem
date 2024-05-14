<?php

namespace App\Models;

use App\Traits\ModelObserval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory,ModelObserval;

    protected $fillable = [
        'title',
        'price',
        'published_at',
    ];


    public function authors(){
        return $this->belongsToMany(Author::class);
    }


    
    public function reviews(){
    return $this->morphMany(Review::class,'reviewable');
    }


    public static function logSubject(Model $model): string
    {
        return sprintf( "Book [id:%d] %s/%s",
            $model->id, $model->name, $model->email
        );
    }
}
