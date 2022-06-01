<?php

namespace App\Services\Web\api\v1;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\RoleRepository;
use App\Services\Interfaces\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $catRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function getRoles()
    {
        return $this->roleRepository->getRoles();
    }

    public function getRolesPluckName()
    {
        return Role::pluck('name','name')->all();
    }

    public function getRole($id)
    {
        return $this->roleRepository->getRole($id);
    }

    public function create(array $data)
    { 
        $result = $this->roleRepository->create($data);
        return $result;
    }

    public function update(Role $role,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->roleRepository->update($role, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update user');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Role $role)
    {
        DB::beginTransaction();
        try {
            $result = $this->roleRepository->destroy($role);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete user');
        }
        DB::commit();
        
        return $result;
    }

}