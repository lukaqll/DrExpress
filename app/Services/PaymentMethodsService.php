<?php 
 namespace App\Services;

use App\Models\PaymentMethods;

class PaymentMethodsService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new PaymentMethods;       
    }

}