<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'adresses';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_district',
        'id_client',
        'id_user',
        'type',
        'street',
        'number',
        'complement',
        'reference',
        'cep',
        'deleted',
    ];

    public $timestamps = false;

    public function district(){
        return $this->hasOne(District::class, 'id', 'id_district');
    }
}
