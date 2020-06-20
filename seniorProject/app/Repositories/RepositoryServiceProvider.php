<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(
            'App\Repositories\UserManagementRepositoryInterface',
            'App\Repositories\UserManagementRepository'
        );
        $this->app->bind(
            'App\Repositories\SPMConfigRepositoryInterface',
            'App\Repositories\SPMConfigRepository'
        );
        $this->app->bind(
            'App\Repositories\AssignmentRepositoryInterface',
            'App\Repositories\AssignmentRepository'
        );
    }
}
