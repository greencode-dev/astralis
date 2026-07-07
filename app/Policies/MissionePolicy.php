<?php

namespace App\Policies;

use App\Models\Missione;
use App\Models\User;

class MissionePolicy
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

    public function view(User $user, Missione $missione): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Missione $missione): bool
    {
        return false;
    }

    public function delete(User $user, Missione $missione): bool
    {
        return false;
    }
}
