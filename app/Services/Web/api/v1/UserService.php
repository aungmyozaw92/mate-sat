<?php

namespace App\Services\Web\api\v1;

use App\User;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Web\api\v1\UserRepository;
use App\Services\Interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $catRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        return $this->userRepository->getUsers();
    }

    public function getUser(User $user)
    {
        return $this->userRepository->getUser($user);
    }
    
    public function getUserRolesPluckName($user)
    {
        return $user->roles->pluck('name','name')->all();
    }

    public function create(array $data)
    {        
        $result = $this->userRepository->create($data);
        return $result;
    }

    public function update(User $user,array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRepository->update($user, $data);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update user');
        }
        DB::commit();

        return $result;
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $result = $this->userRepository->destroy($user);
        }
        catch(Exception $exc){
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to delete user');
        }
        DB::commit();
        
        return $result;
    }

    public function checkPassword($data)
    {
        if (Hash::check($data['password'], auth()->user()->password)) {
             return response()->json([
                'status' => 1, 
                'message' => 'The passwords match'
             ], 200);
        }
        return response()->json([
                'status' => 2, 
                'message' => 'The passwords does not match'
            ], 200);
    }

}