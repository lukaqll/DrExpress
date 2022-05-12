<?php 
 namespace App\Services;

use App\Models\Historic;

class HistoricService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Historic;       
    }

}