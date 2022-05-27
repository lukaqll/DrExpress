<?php 
 namespace App\Services;

use App\Models\ServedDistrict;
use App\Models\User;

class ServedDistrictService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new ServedDistrict;
    }

    public function createLocales( array $data, $throwIfExists=false){

        if( $data['max_delivery_time'] < $data['min_delivery_time'] )
            $this->throwException('O tempo máximo de entrega não pode ser menor que o mínimo');

        foreach( $data['id_district'] as $idDistrict ){

            $exists = $this->get([
                'id_district' => $idDistrict,
                'id_user'     => $data['id_user']
            ]);

            if(!empty($exists)){
                if($throwIfExists){
                    $this->throwException("Você já atende este local");
                } else {
                    continue;
                }
            }

            $dataLocale = [
                'id_district'       => $idDistrict,
                'id_user'           => $data['id_user'],
                'freight'           => $data['freight'],
                'min_delivery_time' => $data['min_delivery_time'],
                'max_delivery_time' => $data['max_delivery_time'],
                'time_type'         => $data['time_type'],
            ];
            $created = $this->create( $dataLocale );
        }

        return true;
    }

    public function filterByUser(User $user, $data){

        $filter = $this->model->where('id_user', $user->id)
                              ->join('districts as d', 'd.id', 'served_districts.id_district')
                              ->join('cities as c', 'c.id', 'd.id_city')
                              ->join('ufs as uf', 'uf.id', 'c.id_uf');

        if( !empty($data['id_uf']) && $data['id_uf'] != 'null' ){
            $filter = $filter->where('uf.id', $data['id_uf']);
        }
        if( !empty($data['id_city']) && $data['id_city'] != 'null' ){
            $filter = $filter->where('c.id', $data['id_city']);
        }
        if( !empty($data['id_district']) && $data['id_district'] != 'null' ){
            $filter = $filter->where('d.id', $data['id_district']);
        }

        return $filter->select('served_districts.*')
                      ->get();

    }
}