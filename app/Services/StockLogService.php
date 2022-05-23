<?php 
 namespace App\Services;

use App\Models\Product;
use App\Models\StockLog;

class StockLogService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new StockLog;       
    }

    public function entry(Product $product, float $amount){

        if( $amount <= 0 )
            $this->throwException('Informe uma quantidade válida');

        return $this->create([
            'id_product' => $product->id,
            'type'       => 'E',
            'amount'     => $amount
        ]);
    }
}