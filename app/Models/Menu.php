<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_menu',
        'harga_menu',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu';
}
