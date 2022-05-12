<?php 
 namespace App\Services;

use App\Models\Uf;

class UfService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Uf;       
    }

}