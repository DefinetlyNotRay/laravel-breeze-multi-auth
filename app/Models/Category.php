<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = "category";
    protected $primaryKey="id_category";
    protected $fillable= [
        "id_category",
        "nama_category"
    ];
    public function book()
    {
        return $this->hasMany(Book::class, 'id_category');
    }
}