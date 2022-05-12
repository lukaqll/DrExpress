<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    use HasFactory;
    
    protected $table = 'product_specs';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_product',
        'id_spec_item',
    ];
    
    public $timestamps = false;
}
