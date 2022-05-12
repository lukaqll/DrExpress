<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;
    
    protected $table = 'role_permissions';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id',
        'id_role',
        'id_permission',
    ];
    
    public $timestamps = false;
}
