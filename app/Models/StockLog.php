<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;
    
    protected $table = 'stock_log';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_product',
        'id_order',
        'type',
        'amount',
        'created_at',
        'updated_at',
    ];
}
