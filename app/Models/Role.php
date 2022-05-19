<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $table = 'roles';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
    ];
    
    public $timestamps = false;

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'role_permissions', 'id_role', 'id_permission');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_roles', 'id_role', 'id_user');
    }

    public function idPermissions(){
        return $this->permissions->pluck('id');
    }
}
