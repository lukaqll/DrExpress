<?php 
 namespace App\Services;

use App\Models\StockLog;

class StockLogService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new StockLog;       
    }

}