<?php
// Policy: before() bypassa per admin. viewAny/view/create/update/delete. Esempio di policy per relazione 1-N

namespace App\Policies;

use App\Models\Categoria;
use App\Models\User;

class CategoriaPolicy
{
    // before(): admin bypass
    public function before(User $user): ?bool
    {
        if ($user->is_admin) return true;
        return null;
    }

    // viewAny: pubblico
    public function viewAny(User $user): bool
    {
        return true;
    }

    // view: pubblico
    public function view(User $user, Categoria $categoria): bool
    {
        return true;
    }

    // create: solo admin
    public function create(User $user): bool
    {
        return false;
    }

    // update: solo admin
    public function update(User $user, Categoria $categoria): bool
    {
        return false;
    }

    // delete: solo admin
    public function delete(User $user, Categoria $categoria): bool
    {
        return false;
    }
}
