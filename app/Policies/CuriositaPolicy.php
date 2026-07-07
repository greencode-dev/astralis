<?php

namespace App\Policies;

use App\Models\Curiosita;
use App\Models\User;

class CuriositaPolicy
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

    public function view(User $user, Curiosita $curiositum): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Curiosita $curiositum): bool
    {
        return false;
    }

    public function delete(User $user, Curiosita $curiositum): bool
    {
        return false;
    }
}
