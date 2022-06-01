<?php

namespace App\Services\Interfaces;

use App\User;

interface UserServiceInterface
{
    public function getUsers();
    public function getUser(User $user);
    public function create(array $data);
    public function update(User $user,array $data);
    public function destroy(User $user);
    public function getUserRolesPluckName(User $user);
    public function checkPassword($data);
}