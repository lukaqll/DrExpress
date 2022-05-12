<?php 
 namespace App\Services;

use App\Models\UserPaymentMethod;

class UserPaymentMethodService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserPaymentMethod;       
    }

}