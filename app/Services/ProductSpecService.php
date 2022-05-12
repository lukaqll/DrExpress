<?php 
 namespace App\Services;

use App\Models\ProductSpec;

class ProductSpecService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductSpec;       
    }

}