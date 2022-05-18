<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $table = 'districts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_city',
        'name',
        'cep',
    ];

    public $timestamps = false;

    public function city(){
        return $this->hasOne(City::class, 'id', 'id_city');
    }
}
