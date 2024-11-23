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

public function returns()
{
    return $this->hasOne(ReturnModel::class, 'id_loan', 'id_loan');
}

public function scopeCurrentlyLoaning($query, $userId)
{
    return $query->where('id_user', $userId)
                 ->where('status', 'picked up');
}

public function scopeReturned($query, $userId)
{
    return $query->where('id_user', $userId)
                 ->where('status', 'returned');
}
public function scopeWait($query)
{
    return $query->where('status', 'reserved');
}
public function scopeLoaning($query)
{
    return $query->where('status', 'picked up');
}
public function scopeWaitingToBePickedUp($query, $userId)
{
    return $query->where('id_user', $userId)
                 ->where('status', 'reserved');
}

}