<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordRecovery extends Model
{
    use HasFactory;

    protected $table = 'password_recovery';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'used',
        'token',
        'created_at',
        'updated_at',
    ];
}
