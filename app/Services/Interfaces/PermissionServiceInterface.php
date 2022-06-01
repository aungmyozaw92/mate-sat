<?php

namespace App\Services\Interfaces;

use Spatie\Permission\Models\Permission;

interface PermissionServiceInterface
{
    public function getApiPermissions();
    public function getPermissions();
    public function getRolePermission($id);
    public function getRolePermissions($id);
    public function create(array $data);
    public function update(Permission $permission,array $data);
    public function destroy(Permission $permission);
    
}