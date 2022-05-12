<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServedDistrict extends Model
{
    use HasFactory;
    
    protected $table = 'served_districts';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_user',
        'id_district',
        'freight',
        'min_delivery_time',
        'max_delivery_time',
    ];
    
    public $timestamps = false;
}
