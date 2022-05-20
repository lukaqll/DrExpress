<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecItem extends Model
{
    use HasFactory;

    protected $table = 'product_spec_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_product_spec',
        'name',
    ];
    
    public $timestamps = false;
}
