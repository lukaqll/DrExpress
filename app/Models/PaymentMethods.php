<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    use HasFactory;
    
    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'image',
        'is_required_data',
        'default_data',
    ];
    
    public $timestamps = false;
}
