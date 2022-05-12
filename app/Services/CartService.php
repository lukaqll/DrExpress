<?php 
 namespace App\Services;

use App\Models\Cart;

class CartService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Cart;       
    }

}