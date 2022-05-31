<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_user',
        'status',
        'deleted',
        'created_at',
        'updated_at',
    ];

    public function items(){
        return $this->hasMany(CartItem::class, 'id_cart')
                    ->where('cart_items.deleted', 0);
    }

    public function getPrice(){

        $price = 0;
        foreach($this->items as $item)
            $price += $item->getPrice();

        return $price;
    }

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_user');
    }

    public function getSellers(){

        $user = $this->user;

        $sellers = User::join('products AS prd', 'prd.id_user', 'users.id')
                        ->join('cart_items AS ci', 'ci.id_product', 'prd.id')
                        ->join('carts AS car', function($join) use($user){
                            $join->on('car.id', 'ci.id_cart')
                                 ->where('car.id_user', $user->id);
                        })
                        ->join('users AS seller', 'seller.id', 'prd.id_user')
                        ->groupBy('seller.id')
                        ->select('seller.*')
                        ->get();
        return $sellers;
    }

    public function getFreight(){

        $value = 0;
        foreach($this->getSellers() as $seller){

            $served = $seller->districtServed();
            if( !empty($served) ){
                $value += $served->freight;
            }
        }

        return $value;
    }

    public function getTotalPice(){
        return $this->getFreight() + $this->getPrice();
    }
}
