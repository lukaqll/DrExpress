<?php
namespace App\Services;

use Illuminate\Validation\ValidationException;

abstract class AbstractService{

    protected $model;

    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    private function resolveModel()
    {
        return app( $this->model );
    }



    private function findColumn( $columnName )
    {
        $isColExists = $this->model->getConnection()
                                    ->getSchemaBuilder()
                                    ->hasColumn($this->model->getTable(), $columnName);
        return $isColExists;
    }
    
    /**
     * create method
     * 
     * @param array $data
     * 
     * @return $this->model
     */
    public function create( array $data )
    {
        return $this->model->create( $data );
    }

    /**
     * get by id
     * 
     * @param int $id
     * 
     * @return $this->model
     */
    public function find( $id )
    {
        $filterable = $this->model;

        if( $this->findColumn('deleted') ){
            $filterable = $filterable->where('deleted', '!=', 1);
        }

        return $filterable->find( intval( $id ) );
    }

    /**
     * update by id method
     * 
     * @param array $data
     * @param int $id
     * 
     * @return $this->model
     */
    public function updateById( $id, array $data )
    {
        $finded = $this->find( intval( $id ) );
        $finded->update( $data );
        return $finded;
    }

    /**
     * update by id method
     * 
     * @param object $model
     * @param int $id
     * 
     * @return bool
     */
    public function update( array $data )
    {
        $this->model->update( $data );
        return $this->model;
    }

    /**
     * get list by array
     * 
     * @param array $filters
     * 
     * @return $this->model
     */
    public function list( array $filters = [], $orderings = [], $order = 'asc' )
    {
     
        $filterable = $this->model;

        foreach( $filters as $key => $value ){

            if( $value != '' )
                $filterable = $filterable->where( $key, $value );
        }

        
        //only not deleted
        if( $this->findColumn('deleted') ){
            $filterable = $filterable->where('deleted', '!=', 1);
        }

        foreach($orderings as $ordering)
            $filterable = $filterable->orderBy( $ordering, $order );
        

        return $filterable->get();
    }

    /**
     * get frist by array
     * 
     * @param array $data
     * 
     * @return $this->model
     */
    public function get( array $data = [] )
    {
        $findable = $this->model->where( $data );

        if( $this->findColumn('deleted') ){
            $findable = $findable->where('deleted', '!=', 1);
        }

        return $findable->first();
    }

    /**
     * delete by id method
     * 
     * @param array $data
     * @param int $id
     * 
     * @return $this->model
     */
    public function deleteById( $id )
    {
        $finded = $this->find( intval( $id ) );
        $finded->delete();
        return $finded;
    }


    public function throwException($message=''){
        if( !is_array($message))
            throw ValidationException::withMessages([$message]);
        
        if( is_array($message) )
            throw ValidationException::withMessages($message);

        throw ValidationException::withMessages(['Ops... Houve um erro!']);
    
    }
}