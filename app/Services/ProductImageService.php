<?php 
 namespace App\Services;

use App\Models\ProductImage;

class ProductImageService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ProductImage;       
    }

}