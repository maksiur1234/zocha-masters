<?php

namespace App\Providers;

use App\Models\Blog\BlogPost;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Gate::policy(BlogPost::class, PostPolicy::class);

        Inertia::share([
            'auth' => function() {
                return [
                    'user' => Auth::user(),
                ];
            },
        ]);
    }
}
