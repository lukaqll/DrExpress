<?php 
 namespace App\Services;

use App\Models\CartItemSpec;

class CartItemSpecService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new CartItemSpec;       
    }

}