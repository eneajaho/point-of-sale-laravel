<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function createUser(User $user)
    {
        return $user->isAdmin() || $user->isManager();
    }
}
