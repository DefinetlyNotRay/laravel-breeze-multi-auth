<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $table = "loan";
    protected $fillable= [
        "id_loan",
        "id_user",
        "id_buku",
        "tanggal_pinjam",
        "tanggal_tenggat",
        "tanggal_pengembalian",
        "denda",
        "keadaan"
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'id_buku');
    }
}