<?php 
 namespace App\Services;

use App\Models\ProductSpecItem;

class ProductSpecItemService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductSpecItem;       
    }

}