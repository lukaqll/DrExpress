<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItemSpec extends Model
{
    use HasFactory;

    protected $table = 'cart_item_spec';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cart_item',
        'id_spec',
        'data',
    ];

    public $timestamps = false;
}
