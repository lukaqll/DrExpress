<?php 
 namespace App\Services;

use App\Models\Spec;

class SpecService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Spec;       
    }

}