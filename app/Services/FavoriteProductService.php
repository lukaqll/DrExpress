<?php 
 namespace App\Services;

use App\Models\FavoriteProduct;
use App\Models\User;

class FavoriteProductService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new FavoriteProduct;       
    }

    public function listProducts( User $user ){

        $result = $user->favoriteProducts;

        return $result;
    }

    public function toogleFavorite(User $user, array $data){

        $exists = $this->get(['id_user' => $user->id, 'id_product' => $data['id_product']]);

        // remove
        if( !empty($exists) ){
            $user->favoriteProducts()->detach($data['id_product']);
        } else {
            $user->favoriteProducts()->attach($data['id_product']);
        }

        return true;
    }
}