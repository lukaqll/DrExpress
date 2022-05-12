<?php 
 namespace App\Services;

use App\Models\Address;

class AddressService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Address;       
    }

}