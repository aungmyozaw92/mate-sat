<?php

namespace App\Services\Interfaces;

use App\Models\Department;

interface DepartmentServiceInterface
{
    public function getDepartments();
    public function getDepartment($id);
    public function create(array $data);
    public function update(Department $department,array $data);
    public function destroy(Department $department);
}