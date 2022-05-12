<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentMethod extends Model
{
    use HasFactory;
    
    protected $table = 'user_payment_methods';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_user',
        'id_payment_method',
        'data',
    ];
    
    public $timestamps = false;
}
