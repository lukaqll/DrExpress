<?php 
 namespace App\Services;

use App\Models\ServedDistrict;

class ServedDistrictService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServedDistrict;       
    }

}