<?php 
 namespace App\Services;

use App\Models\CartItem;

class CartItemService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new CartItem;       
    }

}