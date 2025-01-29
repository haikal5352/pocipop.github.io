<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'img',
        'price',
        'level',
        'description',
        'isFlipped'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'produk';

    protected $casts = [
        'isFlipped' => 'boolean',
        'price' => 'decimal:2'
    ];
}
