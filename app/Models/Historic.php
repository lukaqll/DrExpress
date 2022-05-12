<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    use HasFactory;

    protected $table = 'historic';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'type',
        'reference',
        'historic',
        'payload',
        'created_at',
        'updated_at',
    ];
}
