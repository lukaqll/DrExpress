<?php 
 namespace App\Services;

use App\Models\Order;

class OrderService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Order;       
    }

}