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
        "status"
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}

public function book()
{
    return $this->belongsTo(Book::class, 'id_buku');
}


public function scopeCurrentlyLoaning($query, $userId)
{
    return $query->where('id_user', $userId)
                 ->where('tanggal_tenggat', '>=', now());
}

public function scopeReturned($query, $userId)
{
    return $query->where('id_user', $userId)
                 ->where('tanggal_tenggat', '<', now())
                 ->orderBy('id_loan', 'desc'); // Specify the column and direction
}
public function scopeReturns($query)
{
    return $query
                 ->where('tanggal_tenggat', '<', now())
                 ->orderBy('id_loan', 'desc'); // Specify the column and direction
}
public function scopeLoaning($query)
{
    return $query->where('tanggal_tenggat', '>=', now())
                 ->orderBy('id_loan', 'desc'); // Specify the column and direction
}

}