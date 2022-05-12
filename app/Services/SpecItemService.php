<?php 
 namespace App\Services;

use App\Models\SpecItem;

class SpecItemService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new SpecItem;       
    }

}