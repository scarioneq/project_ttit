<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }
    public function update(User $user)
    {
        return $user->role === 'admin';
    }
    public function delete(User $user)
    {
        return $user->role === 'admin';
    }
}
