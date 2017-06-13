<?php

namespace App\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $web = 'App\Core\Controllers';
    protected $auth = 'App\Auth\Controllers';
    protected $clients = 'App\Clients\Controllers';
    protected $dashboard = 'App\Dashboard\Controllers';
    protected $organizations = 'App\Organizations\Controllers';
    protected $projects = 'App\Projects\Controllers';
    protected $reports = 'App\Reports\Controllers';
    protected $timer = 'App\Timer\Controllers';
    protected $users = 'App\Users\Controllers';
    protected $workspaces = 'App\Workspaces\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        $this->mapAuthRoutes();
        $this->mapClientRoutes();
        $this->mapDashboardRoutes();
        $this->mapOrganizationRoutes();
        $this->mapProjectRoutes();
        $this->mapReportRoutes();
        $this->mapTimerRoutes();
        $this->mapUsersRoutes();
        $this->mapWorkspaceRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::middleware('web')
            ->namespace($this->auth)
            ->group(base_path('app/Auth/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->web)
            ->group(base_path('app/Core/routes.php'));
    }


    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapClientRoutes()
    {
        Route::middleware('web')
            ->namespace($this->clients)
            ->group(base_path('app/Clients/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapDashboardRoutes()
    {
        Route::middleware('web')
            ->namespace($this->dashboard)
            ->group(base_path('app/Dashboard/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapOrganizationRoutes()
    {
        Route::middleware('web')
            ->namespace($this->organizations)
            ->group(base_path('app/Organizations/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapProjectRoutes()
    {
        Route::middleware('web')
            ->namespace($this->projects)
            ->group(base_path('app/Projects/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapReportRoutes()
    {
        Route::middleware('web')
            ->namespace($this->reports)
            ->group(base_path('app/Reports/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapTimerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->timer)
            ->group(base_path('app/Timer/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapUsersRoutes()
    {
        Route::middleware('web')
            ->namespace($this->users)
            ->group(base_path('app/Users/routes.php'));
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapWorkspaceRoutes()
    {
        Route::middleware('web')
            ->namespace($this->workspaces)
            ->group(base_path('app/Workspaces/routes.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
