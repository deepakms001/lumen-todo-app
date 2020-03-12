<?php

namespace App\Operations\Auth;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Exception;

class UserPermissionCheck
{
    public function run(User $user, $object)
    {
        if ($object instanceof Category && $user->id == $object->user_id) {
            return true;
        } else if ($object instanceof Task) {
            $object->load('category');
            if ($object->category->user_id == $user->id) {
                return true;
            }
        }
        throw new Exception("You don't have permission to access this resource.", 401);
    }
}
