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
        'time_type'
    ];
    
    public $timestamps = false;

    public function district(){
        return $this->hasOne(District::class, 'id', 'id_district');
    }

    public function timeTypeText(){
        $types = [
            'i' => 'minutos',
            'H' => 'horas',
            'd' => 'dias'
        ];

        return !empty($types[$this->time_type]) ? $types[$this->time_type] : $this->time_type;
    }
}
