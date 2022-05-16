<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;
    
    protected $table = 'specs';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_category',
        'name',
        'is_required',
    ];
    
    public $timestamps = false;

    public function items(){
        return $this->hasMany(SpecItem::class, 'id_spec', 'id');
    }
}
