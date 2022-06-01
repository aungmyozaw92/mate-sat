<?php

namespace App\Repositories\Web\api\v1;

use Spatie\Permission\Models\Role;
use App\Repositories\BaseRepository;

class RoleRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Role::class;
    }

    public function getRoles()
    {
        $roles = Role::with(['permissions'])
                    ->orderBy('id','asc');
        if (request()->has('paginate')) {
            $roles = $roles->paginate(request()->get('paginate'));
        } else {
            $roles = $roles->get();
        }
        return $roles;
    }
    /**
     * @param array $data
     *
     * @return Role
     */
    public function create(array $data) : Role
    {
        // dd($data['permission']);
        $role = Role::create([
            'name'   => $data['name'],
        ]);
        $role->syncPermissions($data['permission']);
        return $role;
    }

    /**
     * @param Agent  $agent
     * @param array $data
     *
     * @return mixed
     */
    public function update(Role $role, array $data) : Role
    {
        $role->name = isset($data['name']) ? $data['name'] : $role->name ;
       
        if ($role->isDirty()) {
            $role->save();
        }

        $role->syncPermissions($data['permission']);

        return $role->refresh();
    }

    /**
     * @param Role $role
     */
    public function destroy(Role $role)
    {
        $deleted = $this->deleteById($role->id);

        if ($deleted) {
            $role->save();
        }
    }
}
