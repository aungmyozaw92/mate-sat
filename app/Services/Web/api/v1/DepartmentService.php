<?php

namespace App\Services\Web\api\v1;

use Exception;
use App\Models\Department;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Web\api\v1\DepartmentRepository;
use App\Services\Interfaces\DepartmentServiceInterface;

class DepartmentService implements DepartmentServiceInterface
{
    protected $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartments()
    {
        return $this->departmentRepository->getDepartments();
    }

    public function getDepartment($id)
    {
        return $this->departmentRepository->getDepartment($id);
    }
    
    public function create(array $data)
    {        
        $result = $this->departmentRepository->create($data);
        return $result;
    }

    public function update(Department $department,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->departmentRepository->update($department, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update Department');
        }
        DB::commit();

        return $result;
    }

    public function destroy(Department $department)
    {
        DB::beginTransaction();
        try {
            $result = $this->departmentRepository->destroy($department);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete Department');
        }
        DB::commit();
        
        return $result;
    }

}