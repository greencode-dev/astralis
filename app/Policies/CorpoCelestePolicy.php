<?php

namespace App\Policies;

use App\Models\CorpoCeleste;
use App\Models\User;

class CorpoCelestePolicy
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

    public function view(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return false;
    }

    public function delete(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return false;
    }
}
