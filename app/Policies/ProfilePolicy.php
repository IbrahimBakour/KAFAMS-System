
<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    public function index(User $user): bool
    {
        return in_array($user->role, ['KAFA_ADMIN','MUIP_ADMIN','TEACHER']);
    }

    public function view(User $user, Profile $profile): bool
    {
        return $user->role === 'KAFA_ADMIN'
            || $user->role === 'MUIP_ADMIN'
            || ($user->role === 'TEACHER' && optional($profile->class)->teacher_id === $user->id)
            || ($user->role === 'PARENT' && $profile->parent_id === $user->id);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['PARENT','KAFA_ADMIN']);
    }

    public function update(User $user, Profile $profile): bool
    {
        if (in_array($user->role, ['KAFA_ADMIN','MUIP_ADMIN'])) return true;
        if ($user->role === 'PARENT') return $profile->parent_id === $user->id;
        if ($user->role === 'TEACHER') return optional($profile->class)->teacher_id === $user->id;
        return false;
    }

    public function delete(User $user, Profile $profile): bool
    {
        return in_array($user->role, ['KAFA_ADMIN','MUIP_ADMIN']);
    }
}
