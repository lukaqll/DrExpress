<?php

namespace App\Policies;

use App\Models\ServedDistrict;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ServedDistrictPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function update(User $user, ServedDistrict $servedDistrict){

        return $user->id == $servedDistrict->id_user && $servedDistrict->deleted == 0 
            ? Response::allow()
            : Response::deny('Não é possível alterar este registro');
    }
}
