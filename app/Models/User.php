<?php

namespace App\Models;

use App\Http\Resources\ServedDistrictResource;
use App\Services\CartService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
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

    public function defaultPicture(){
        
        $fileExists = Storage::disk('public')->exists($this->picture);
        if( $fileExists ){
            return '/storage/'.$this->picture;
        }
        return '/defaultImages/default-picture.png';
    }

    public function defaultBanner(){
        $fileExists = Storage::disk('public')->exists($this->banner);
        if( $fileExists ){
            return '/storage/'.$this->banner;
        }
        return '/defaultImages/default-banner.jpg';
    }

    public function config(){
        return $this->hasOne(SellerConfig::class, 'id_user');
    }

    public function favoriteProducts(){
        return $this->belongsToMany(Product::class, 'favorite_products', 'id_user', 'id_product');
    }

    public function getCart(){
        $cartService = new CartService;
        return $cartService->getCart($this);
    }

    public function defaultAddress(){
        return $this->hasOne(Address::class, 'id', 'id_address');
    }

    public function districtServed(){

        $user = auth('api')->user();
        $seller = $this;

        if(empty($user))
            return false;

        if( empty($user->defaultAddress) )
            return false;

        $result = ServedDistrict::where('id_user', $seller->id)
                            ->where('id_district', $user->defaultAddress->id_district)
                            ->first();

        if( !empty($result) ){
            return new ServedDistrictResource($result);
        }
        
        return false;
    }
}
