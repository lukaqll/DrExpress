<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_user',
        'id_brand',
        'name',
        'description',
        'model',
        'price',
        'slug',
        'guarantee',
        'created_at',
        'updated_at',
    ];
}
