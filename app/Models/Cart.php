<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'id_seller',
        'status',
        'deleted',
        'created_at',
        'updated_at',
    ];
}
