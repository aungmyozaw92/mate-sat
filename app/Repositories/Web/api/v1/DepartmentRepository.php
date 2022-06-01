<?php

namespace App\Repositories\Web\api\v1;

use App\Models\Department;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Department::class;
    }

    public function getDepartments()
    {
        $departments = Department::orderBy('id','asc');
         if (request()->has('paginate')) {
            $departments = $departments->paginate(request()->get('paginate'));
        } else {
            $departments = $departments->get();
        }
        return $departments;
    }

    /**
     * @param array $data
     *
     * @return Department
     */
    public function create(array $data) : Department
    {
        $department = Department::create([
            'name'   => $data['name']
        ]);
        return $department;
    }

    /**
     * @param Department  $department
     * @param array $data
     *
     * @return mixed
     */
    public function update(Department $department, array $data) : Department
    {
        $department->name = isset($data['name']) ? $data['name'] : $department->name ;
        
        if ($department->isDirty()) {
            $department->save();
        }
        return $department->refresh();
    }

    /**
     * @param Department $department
     */
    public function destroy(Department $department)
    {
        $deleted = $this->deleteById($department->id);

        if ($deleted) {
            $department->deleted_by = auth()->user()->id;
            $department->save();
        }
    }
}
