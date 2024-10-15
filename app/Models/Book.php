<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = "books";
    protected $fillable= [
        "id",
        "title",
        "author",
        "id_category",
        "status"
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}