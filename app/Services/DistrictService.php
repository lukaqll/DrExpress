<?php 
 namespace App\Services;

use App\Models\District;

class DistrictService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new District;       
    }

}