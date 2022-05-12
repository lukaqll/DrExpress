<?php 
 namespace App\Services;

use App\Models\Permission;

class PermissionService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Permission;       
    }

    public function getTopicGroup(){

        $groups = $this->model->groupBy('topic')->select('topic')->get();

        $result = [];
        foreach( $groups as $topic ){
            $result[] = [
                'topic' => $topic->topic,
                'permissions' => $this->model->where('topic', $topic->topic)->get()
            ];
        }

        return $result;
    }
}