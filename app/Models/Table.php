<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_number',
        'name',
        'status',
        'qr_code',
    ];

    // Relasi ke Order jika perlu (opsional)
    // public function orders() { return $this->hasMany(Order::class); }
}