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
}