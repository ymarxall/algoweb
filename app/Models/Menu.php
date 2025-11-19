<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image_path',
    ];

    /**
     * Relasi ke Category (satu menu milik satu kategori).
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}