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
    ];

    public $timestamps = false;
}
