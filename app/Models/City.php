<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_uf',
        'name',
        'ibge_code',
        'cep',
    ];

    public $timestamps = false;

    public function uf(){
        return $this->hasOne(Uf::class, 'id', 'id_uf');
    }

    public function districts(){
        return $this->hasMany(District::class, 'id_city', 'id');
    }
}
