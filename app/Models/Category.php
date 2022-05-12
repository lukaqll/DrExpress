<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_category',
        'name',
        'required_cro',
        'linkable',
    ];

    public $timestamps = false;
}
