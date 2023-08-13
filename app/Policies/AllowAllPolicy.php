<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AllowAllPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        return true;
    }
}
