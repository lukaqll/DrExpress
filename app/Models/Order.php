<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_cart',
        'id_address',
        'id_user_payment_method',
        'status',
        'price',
        'freight',
        'is_delivery',
        'is_money',
        'conclued_at',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;
}
