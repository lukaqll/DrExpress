<?php 
 namespace App\Services;

use App\Models\Brand;

class BrandService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Brand;       
    }

}