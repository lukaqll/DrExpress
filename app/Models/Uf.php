<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    use HasFactory;
    
    protected $table = 'ufs';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'initials',
    ];
    
    public $timestamps = false;
}
