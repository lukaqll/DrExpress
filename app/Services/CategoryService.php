<?php 
 namespace App\Services;

use App\Models\Category;

class CategoryService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Category;       
    }

}