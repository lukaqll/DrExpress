<?php 
 namespace App\Services;

use App\Models\User;

class UserService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;       
    }

}