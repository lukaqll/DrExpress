<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerConfig extends Model
{
    use HasFactory;

    protected $table = 'seller_config';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_user',
        'is_open',
        'is_delivery',
        'is_physical',
        'visibility',
    ];
    
    public $timestamps = false;

    public function user(){
        return $this->hasOne(User::class, 'id'. 'id_user');
    }

    public function visibilityText(){
        $status = [
            'V' => 'Visível',
            'O' => 'Oculto',
            'B' => 'Em breve',
        ];

        return !empty($status[$this->visibility]) ? $status[$this->visibility] : $this->visibility;
    }
}
