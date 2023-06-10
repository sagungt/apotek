<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('super-admin', fn (User $user) => $user->role == 1);
        Gate::define('admin', fn (User $user) => $user->role == 2 || $user->role == 1);
        Gate::define('user', fn (User $user) => $user->role == 3);

        // Auth::viaRequest('with-shared-password', function (Request $request) {
        //     $user = User::where('username', $request->only('username'))->first();
        //     $withPassword = Hash::check($request->only('password'), $user->password);
        //     $withSharedPassword = Hash::check($request->only('password'), $user->hashed_password);
        //     return $withPassword || $withSharedPassword;
        // });
    }
}
