<?php 
 namespace App\Services;

use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserService extends AbstractService
{
    protected $model;

    public function __construct()
    {
        $this->model = new User;       
    }

    public function listOperators(){

        return $this->model->join('user_roles AS ur', 'ur.id_user', 'users.id')
                           ->join('roles AS r', function($join){
                               $join->on('r.id', 'ur.id_role')
                                    ->whereIn('r.slug', ['admin', 'operator']);
                           })
                           ->select('users.*')
                           ->groupBy('users.id')
                           ->get();
    }

    public function listSellers(){

        return $this->model->join('user_roles AS ur', 'ur.id_user', 'users.id')
                           ->join('roles AS r', function($join){
                               $join->on('r.id', 'ur.id_role')
                                    ->whereIn('r.slug', ['seller']);
                           })
                           ->select('users.*')
                           ->groupBy('users.id')
                           ->get();
    }

    public function createOperator( $data ){

        
        $this->passwordValidation($data);

        $roleService = new RoleService;
        
        $data['password'] = bcrypt($data['password']);
        $data['status'] = 'A';
        $user = $this->create( $data );

        $operatorRole = $roleService->get(['slug' => 'operator']);

        if( empty($operatorRole) )
            throw ValidationException::withMessages(['Função de operador não cadastrada, entre em contato com o administrador do sistema']);

        $user->roles()->attach($operatorRole);
            
        return $user;
    }


    public function createSeller( $data ){

        
        $this->passwordValidation($data);

        $roleService = new RoleService;
        
        $data['password'] = bcrypt($data['password']);
        $data['status'] = 'A';
        $user = $this->create( $data );

        $sellerRole = $roleService->get(['slug' => 'seller']);

        if( empty($sellerRole) )
            throw ValidationException::withMessages(['Função de operador não cadastrada, entre em contato com o administrador do sistema']);

        $user->roles()->attach($sellerRole);
            
        return $user;
    }


    public function passwordValidation( $data ){

        $errors = [];

        if( empty($data['password']) )
            $errors[] = 'Informa a senha';

        if( empty($data['password_confirmation']) )
            $errors[] = 'Confirme a senha';

        if( strlen($data['password']) < 6 )
            $errors[] = 'A senha deve ter no mínimo 6 caracteres';

        if( $data['password'] !== $data['password_confirmation'] )
            $errors[] = 'As senhas não conferem';

        if( !empty($errors) )
            throw ValidationException::withMessages($errors);

        return true;
    }
}