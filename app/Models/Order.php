<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'table_id',
        'customer_name',
        'payment_method',
        'subtotal',
        'total_price',
        'discount',
        'additional_charges',
        'final_total',
        'status',
        'estimated_minutes',
        'estimated_completion_at',
        'actual_completion_at',
        'snap_token',
    ];

    protected $casts = [
        'estimated_completion_at' => 'datetime',
        'actual_completion_at' => 'datetime',
    ];

    // Relasi ke User (opsional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Table
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    // Relasi ke Menus
    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'order_details')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    // Relasi ke Order Status History
    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatus::class)->orderBy('status_at', 'asc');
    }

    // Alias for statusHistories (used in views)
    public function statuses(): HasMany
    {
        return $this->statusHistories();
    }

    /**
     * Get latest status
     */
    public function latestStatus(): ?OrderStatus
    {
        return $this->statusHistories()->orderBy('status_at', 'desc')->first();
    }

    /**
     * Calculate final total (total - discount + additional)
     */
    public function calculateFinalTotal(): float
    {
        $discount = $this->discount ?? 0;
        $additional = $this->additional_charges ?? 0;
        $total = $this->total_price ?? 0;
        return (float) (($total - $discount) + $additional);
    }

    /**
     * Generate order number if not exists
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->order_number) {
                $model->order_number = 'ORD-' . date('YmdHis') . '-' . str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            }
        });
    }
}