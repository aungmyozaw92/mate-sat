<?php

namespace App\Http\Resources\Web\api\v1\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Web\api\v1\Role\RoleCollection;
use App\Http\Resources\Web\api\v1\Department\DepartmentResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'email_verified_at' => $this->email_verified_at,
            'department' => DepartmentResource::make($this->whenLoaded('department')),
            'approved_by' => $this->approved_by ? $this->approved_user->name : null, 
            'suspend_by' => $this->suspend_by ? $this->suspend_user->name : null, 
            'created_by' => $this->created_user ? $this->created_user->name : null,
            'updated_by' => $this->updated_by ? $this->updated_user->name : null,
            'deleted_by' => $this->deleted_by ? $this->deleted_user->name : null,
            'approved_at' => $this->approved_at,
            'suspend_at' => $this->suspend_at,
            'roles' => RoleCollection::make($this->whenLoaded('roles')),
        ];
    }
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => 1,
        ];
    }
}
