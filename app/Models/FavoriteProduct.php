<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    use HasFactory;

    protected $table = 'favorite_products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'id_product'
    ];

    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class, 'id', 'id_product');
    }
}
