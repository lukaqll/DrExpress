<?php 
 namespace App\Services;

use App\Models\SellerConfig;

class SellerConfigService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new SellerConfig;       
    }

}