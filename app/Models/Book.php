<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = "books";
    protected $primaryKey="id";
    protected $fillable= [
        "id",
        "title",
        "author",
        "id_category",
        "status",
        "cover_img",
        "desc",
        "total_loan"
    ];
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
    public function loans()
{
    return $this->hasMany(Loan::class, 'id_buku');
}

}