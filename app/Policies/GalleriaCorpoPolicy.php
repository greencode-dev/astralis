<?php

namespace App\Policies;

use App\Models\GalleriaCorpo;
use App\Models\User;

class GalleriaCorpoPolicy
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

    public function view(User $user, GalleriaCorpo $galleriaCorpo): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, GalleriaCorpo $galleriaCorpo): bool
    {
        return false;
    }

    public function delete(User $user, GalleriaCorpo $galleriaCorpo): bool
    {
        return false;
    }
}
