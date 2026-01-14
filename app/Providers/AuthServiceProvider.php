
<?php

namespace App\Providers;

use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Profile::class => ProfilePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('dashboard.view.parent', fn($user) => $user->role === 'PARENT');
        Gate::define('dashboard.view.teacher', fn($user) => $user->role === 'TEACHER');
        Gate::define('dashboard.view.admin', fn($user) => in_array($user->role, ['KAFA_ADMIN','MUIP_ADMIN']));

        Gate::define('profiles.index', fn($user) => in_array($user->role, ['KAFA_ADMIN','MUIP_ADMIN','TEACHER']));
    }
}
