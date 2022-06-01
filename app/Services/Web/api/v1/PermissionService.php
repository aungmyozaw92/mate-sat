<?php

namespace App\Services\Web\api\v1;

use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use App\Services\Interfaces\PermissionServiceInterface;

class PermissionService implements PermissionServiceInterface
{
    public function getApiPermissions()
    {
        return Permission::get();
    }

    public function getPermissions()
    {
        return Permission::where('guard_name','web')->get();
    }

    public function getRolePermission($id)
    {
        return Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get(); 
    }

    public function getRolePermissions($id)
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        
    }

    public function create(array $data)
    {        
        $permission = Permission::create([
                'name'   => $data['name'],
                'guard_name'   => 'web',
            ]);
        return $permission;
    }

    public function update(Permission $permission,array $data)
    {
        DB::beginTransaction();
        try {
            $permission->name = isset($data['name']) ? $data['name'] : $permission->name ;
        
            if ($permission->isDirty()) {
                $permission->save();
            }
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Group');
        }
        DB::commit();

        return $permission->refresh();
    }

    public function destroy(Permission $permission)
    {
        DB::beginTransaction();
        try {
            $result = Permission::destory($permission->id);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Group');
        }
        DB::commit();
        
        return $result;
    }

}