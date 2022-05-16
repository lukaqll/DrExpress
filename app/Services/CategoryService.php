<?php 
 namespace App\Services;

use App\Models\Category;

class CategoryService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Category;       
    }

    public function treeList(){

        return $this->model->where('linkable', 1)
                            ->where ('id_category', null)
                            ->orderByRaw('linkable, name')
                            ->get();
    }

}