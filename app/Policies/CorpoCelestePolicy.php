<?php
// Policy: before() bypassa per admin, altrimenti blocca create/update/delete per non-admin

namespace App\Policies;

use App\Models\CorpoCeleste;
use App\Models\User;

class CorpoCelestePolicy
{
    // before(): se is_admin → bypassa tutti i metodi successivi (return true)
    public function before(User $user): ?bool
    {
        if ($user->is_admin) return true;
        return null;
    }

    // viewAny: pubblico (return true)
    public function viewAny(User $user): bool
    {
        return true;
    }

    // view: pubblico (return true)
    public function view(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return true;
    }

    // create: solo admin (return false per non-admin)
    public function create(User $user): bool
    {
        return false;
    }

    // update: solo admin
    public function update(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return false;
    }

    // delete: solo admin
    public function delete(User $user, CorpoCeleste $corpoCeleste): bool
    {
        return false;
    }
}
