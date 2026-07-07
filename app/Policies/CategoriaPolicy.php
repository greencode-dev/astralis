<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;

class CategoriaPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->is_admin) return true;
        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Categoria $categoria): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Categoria $categoria): bool
    {
        return false;
    }

    public function delete(User $user, Categoria $categoria): bool
    {
        return false;
    }
}
