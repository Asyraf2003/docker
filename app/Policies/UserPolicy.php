<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_OTHER]);
    }

    public function view(User $user, User $model): bool
    {
        return $user->role === User::ROLE_ADMIN || $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function update(User $user, User $model): bool
    {
        return $user->role === User::ROLE_ADMIN && $user->id !== $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role === User::ROLE_ADMIN && $user->id !== $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return $user->role === User::ROLE_ADMIN;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return $user->role === User::ROLE_ADMIN && $user->id !== $model->id;
    }
}
