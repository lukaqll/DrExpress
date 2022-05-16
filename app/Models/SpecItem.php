<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecItem extends Model
{
    use HasFactory;
    
    protected $table = 'spec_items';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_spec',
        'name',
    ];
    
    public $timestamps = false;

    public function products(){
        return $this->belongsToMany(Product::class, 'product_specs', 'id_product', 'id_spec_item');
    }
}
