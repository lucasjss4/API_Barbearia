<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function get_User(int $id)
    {
        return User::find($id);
    }
}
