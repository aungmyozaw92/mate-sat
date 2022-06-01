<?php

namespace App\Repositories\Web\api\v1;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getUsers()
    {
        $users = User::with(['roles','created_user','approved_user','suspend_user','department'])
                    ->filter(request()->only(['search']))
                    ->orderBy('id','desc');
        if (request()->has('paginate')) {
            $users = $users->paginate(request()->get('paginate'));
        } else {
            $users = $users->get();
        }
        return $users;
    }
    /**
     * @param array $data
     *
     * @return User
     */
    public function create(array $data) : User
    {
        $user = User::create([
            'name'              => $data['name'],
            'username'          => $data['username'],
            'password'          => Hash::make($data['password']),
            'email'             => $data['email'],
            'department_id'     => $data['department_id'],
            'phone'             => isset($data['phone']) ? $data['phone'] : null,
            'address'           => isset($data['address']) ? $data['address'] : null,
            'created_by'        => auth()->user()->id,
            'approved_by'       =>  (isset($data['is_approved']) && $data['is_approved']) ? auth()->user()->id : null,
            'suspend_by'        =>  (isset($data['is_suspend']) && $data['is_suspend']) ? auth()->user()->id : null,
            'approved_at'       =>  (isset($data['is_approved']) && $data['is_approved']) ? date('Y-m-d H:i:s')  : null,
            'suspend_at'        =>  (isset($data['is_suspend']) && $data['is_suspend']) ? date('Y-m-d H:i:s')  : null,
        ]);
        $user->assignRole($data['roles']);
        return $user;
    }

    /**
     * @param User  $user
     * @param array $data
     *
     * @return mixed
     */
    public function update(User $user, array $data) : User
    {
        $user->name = isset($data['name']) ? $data['name'] : $user->name ;
        $user->email = isset($data['email']) ? $data['email']: $user->email;
        $user->phone = isset($data['phone']) ? $data['phone'] : $user->phone;
        $user->address = isset($data['address']) ? $data['address'] : $user->address;
        $user->department_id = isset($data['department_id']) ? $data['department_id'] : $user->department_id;
        $user->password = isset($data['password'])? Hash::make($data['password']) : $user->password;
        $user->approved_by = (isset($data['is_approved']) && $data['is_approved']) ? auth()->user()->id : null;
        $user->suspend_by = (isset($data['is_suspend']) && $data['is_suspend']) ? auth()->user()->id : null;
        $user->approved_at = (isset($data['is_approved']) && $data['is_approved']) ? date('Y-m-d H:i:s') : null;
        $user->suspend_at = (isset($data['is_suspend']) && $data['is_suspend']) ? date('Y-m-d H:i:s') : null;

        if ($user->isDirty()) {
            $user->updated_by = auth()->user()->id;
            $user->save();
        }

        if (isset($data['roles']) && $data['roles']) {
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            $user->assignRole($data['roles']);
        }

        return $user->refresh();
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        $deleted = $this->deleteById($user->id);

        if ($deleted) {
            $user->deleted_by = auth()->user()->id;
            $user->save();
        }
    }
}
