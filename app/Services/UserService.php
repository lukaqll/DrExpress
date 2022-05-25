<?php 
 namespace App\Services;

use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

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

        $user->config()->create([
            'is_open' => 0, 'visibility' => 'O'
        ]);

        // create address
        if(!empty($data['id_district'])){
            $data['id_user'] = $user->id;
            $address = Address::create($data);
            $user->update(['id_address' => $address->id]);
        }

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

    /**
     * upload logo
     * 
     * @param binary $file
     * 
     * @return Store $store
     */
    public function uploadPicture( $file, User $user ){

        $fileName = Storage::disk('public')->put('user_pictures', $file);
        
        $fileDirName = public_path( 'storage/' . $fileName );
        $img = Image::make( $fileDirName );
        $width = $img->width();
        $height = $img->height();
        $crop = $width <= $height ? $width : $height;
        $img->crop($crop, $crop)->resize( 300,300 )->save( $fileDirName );
        
        $oldFile = $user->picture;
        if(!empty($fileName)){
            $user->update(['picture' => $fileName]);
            $oldFileDeleted = Storage::disk('public')->delete($oldFile);
        }
        return $user;
    }

    /**
     * upload banner
     * 
     * @param binary $file
     * 
     * @return Store $store
     */
    public function uploadBanner( $file, User $user ){

        $fileName = Storage::disk('public')->put('user_banners', $file);
        
        $fileDirName = public_path( 'storage/' . $fileName );
        $img = Image::make( $fileDirName ); 
        $img->fit( 1080, 480, null, 'center' )->save( $fileDirName );
        
        $oldFile = $user->banner;
        if(!empty($fileName)){
            $user->update(['banner' => $fileName]);
            $oldFileDeleted = Storage::disk('public')->delete($oldFile);
        }
        return $user;
    }
}