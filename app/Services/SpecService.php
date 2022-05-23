<?php 
 namespace App\Services;

use App\Models\Category;
use App\Models\Spec;

class SpecService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Spec;       
    }

    public function validateRequiredSpecs( Category $category, array $specs ){

        $errors = [];
        foreach( $category->specs as $spec ){

            if( empty($spec->is_multiple) && is_array($specs[$spec->id]) && count($specs[$spec->id]) > 1 ){
                $errors[] = "Ĩnforme apenas um item em $spec->name";
            }

            if( !empty($spec->is_required) ){
                if( empty($specs[$spec->id]) )
                    $errors[] = "Ĩnforme o campo $spec->name";
            }
        }

        return $errors;
    }
}