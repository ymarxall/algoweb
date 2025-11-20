<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
        'notes',
        'status_at',
        'changed_by',
    ];

    protected function casts(): array
    {
        return [
            'status_at' => 'datetime',
        ];
    }

    /**
     * Relationship to Order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relationship to User (who changed status)
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    /**
     * Alias for changedBy
     */
    public function user(): BelongsTo
    {
        return $this->changedBy();
    }
}
