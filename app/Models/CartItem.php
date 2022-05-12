<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cart',
        'id_product',
        'price',
        'deleted',
    ];

    public $timestamps = false;
}
