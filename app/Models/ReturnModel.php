<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReturnModel extends Model
{
    use HasFactory;

    protected $table = "return";
    protected $fillable= [
        "id",
        "id_loan",
        "tanggal_pengembalian",
        "denda",
        "keadaan",
    ];
    public function loan()
{
    return $this->belongsTo(Loan::class, 'id_loan');
}

}