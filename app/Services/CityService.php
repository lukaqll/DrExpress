<?php 
 namespace App\Services;

use App\Models\City;

class CityService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new City;       
    }

}