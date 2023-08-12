<?php

namespace App\Policies;

use App\Models\Desk;
use App\Models\User;

class DeskPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        // Check if the user is an admin
        return $user->is_admin;
    }
}
