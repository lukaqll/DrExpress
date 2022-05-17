<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_city',
        'id_address',
        'name',
        'email',
        'doc_number',
        'phone',
        'birthdate',
        'cro',
        'status',
        'picture',
        'banner',
        'is_delivery',
        'is_physical',
        'is_student',
        'notification_token',
        'cro_validated_at',
        'email_verified_at',
        'created_at',
        'updated_at',
        'password'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles(){ 
        return $this->belongsToMany(Role::class, 'user_roles', 'id_user', 'id_role');
    }

    public function hasPermission( Permission $permission ){
        return $this->hasAnyRoles($permission->roles);
    }

    public function hasAnyRoles( $roles ){
        if( is_array($roles) || is_object($roles) ){
            return !! $roles->intersect($this->roles)->count();
        }

        return $this->roles->contains('slug', $roles);
    }

    public function permissions(){
        $roles = $this->roles()
                    ->with('permissions')
                    ->get();

        $result = [];
        foreach($roles as $role ){
            foreach( $role->permissions as $permission ){
                if( empty($result[ $permission->slug ]) )
                    $result[] = $permission->slug;
            }
        }

        return $result;
    }

    public function statusText(){
        $status = [
            'A' => 'Ativo',
            'I' => 'Inativo',
        ];

        return !empty($status[$this->status]) ? $status[$this->status] : $this->status;
    }

    public function city(){
        return $this->hasOne(City::class, 'id', 'id_city');
    }
}
