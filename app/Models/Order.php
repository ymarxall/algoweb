<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'total_price',
        'payment_status',
        'kitchen_status',
        'snap_token',
    ];

    // Relasi ke User (opsional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Table (INI YANG PENTING—pastikan ada!)
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    // Relasi ke Menus (sudah ada)
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'order_details')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}