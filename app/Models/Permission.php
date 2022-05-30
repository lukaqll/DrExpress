<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'slug',
        'topic',
        'description',
        'active',
    ];
    
    public $timestamps = false;

    public function topicText(){
        $topics = [
            'user' => 'Usuário',
            'permission' => 'Permissão',
            'category' => 'Categoria',
            'address' => 'Endereço',
            'brand' => 'Marca',
            'cart' => 'Carrinho de Compras',
        ];

        return !empty($topics[$this->topic]) ? $topics[$this->topic] : $this->topic;
    }

    public function roles(){
        return $this->belongsToMany(Role::class, 'role_permissions', 'id_permission', 'id_role');
    }
}
