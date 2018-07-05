<?php

namespace Jeffersonmartin\Buildhat;

use Illuminate\Support\ServiceProvider;
use Jeffersonmartin\Buildhat\Commands\API\APIControllerGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\API\APIGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\API\APIRequestsGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\API\TestsGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\APIScaffoldGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Common\MigrationGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Common\ModelGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Common\RepositoryGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Publish\GeneratorPublishCommand;
use Jeffersonmartin\Buildhat\Commands\Publish\LayoutPublishCommand;
use Jeffersonmartin\Buildhat\Commands\Publish\PublishTemplateCommand;
use Jeffersonmartin\Buildhat\Commands\Publish\VueJsLayoutPublishCommand;
use Jeffersonmartin\Buildhat\Commands\RollbackGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Scaffold\ControllerGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Scaffold\RequestsGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Scaffold\ScaffoldGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\Scaffold\ViewsGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\VueJs\VueJsGeneratorCommand;
use Jeffersonmartin\Buildhat\Commands\GenerateApiFromConfigModelsCommand;

class BuildhatServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__.'/../config/buildhat.php';

        $this->publishes([
            $configPath => config_path('buildhat.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('buildhat.publish', function ($app) {
            return new GeneratorPublishCommand();
        });

        $this->app->singleton('buildhat.api', function ($app) {
            return new APIGeneratorCommand();
        });

        $this->app->singleton('buildhat.scaffold', function ($app) {
            return new ScaffoldGeneratorCommand();
        });

        $this->app->singleton('buildhat.publish.layout', function ($app) {
            return new LayoutPublishCommand();
        });

        $this->app->singleton('buildhat.publish.templates', function ($app) {
            return new PublishTemplateCommand();
        });

        $this->app->singleton('buildhat.api_scaffold', function ($app) {
            return new APIScaffoldGeneratorCommand();
        });

        $this->app->singleton('buildhat.migration', function ($app) {
            return new MigrationGeneratorCommand();
        });

        $this->app->singleton('buildhat.model', function ($app) {
            return new ModelGeneratorCommand();
        });

        $this->app->singleton('buildhat.repository', function ($app) {
            return new RepositoryGeneratorCommand();
        });

        $this->app->singleton('buildhat.api.controller', function ($app) {
            return new APIControllerGeneratorCommand();
        });

        $this->app->singleton('buildhat.api.requests', function ($app) {
            return new APIRequestsGeneratorCommand();
        });

        $this->app->singleton('buildhat.api.tests', function ($app) {
            return new TestsGeneratorCommand();
        });

        $this->app->singleton('buildhat.scaffold.controller', function ($app) {
            return new ControllerGeneratorCommand();
        });

        $this->app->singleton('buildhat.scaffold.requests', function ($app) {
            return new RequestsGeneratorCommand();
        });

        $this->app->singleton('buildhat.scaffold.views', function ($app) {
            return new ViewsGeneratorCommand();
        });

        $this->app->singleton('buildhat.rollback', function ($app) {
            return new RollbackGeneratorCommand();
        });

        $this->app->singleton('buildhat.vuejs', function ($app) {
            return new VueJsGeneratorCommand();
        });
        $this->app->singleton('buildhat.publish.vuejs', function ($app) {
            return new VueJsLayoutPublishCommand();
        });

        $this->app->singleton('buildhat.generate.config.models', function ($app) {
            return new GenerateApiFromConfigModelsCommand();
        });

        $this->commands([
            'buildhat.publish',
            'buildhat.api',
            'buildhat.scaffold',
            'buildhat.api_scaffold',
            'buildhat.publish.layout',
            'buildhat.publish.templates',
            'buildhat.migration',
            'buildhat.model',
            'buildhat.repository',
            'buildhat.api.controller',
            'buildhat.api.requests',
            'buildhat.api.tests',
            'buildhat.scaffold.controller',
            'buildhat.scaffold.requests',
            'buildhat.scaffold.views',
            'buildhat.rollback',
            'buildhat.vuejs',
            'buildhat.publish.vuejs',
            'buildhat.generate.config.models',
        ]);
    }
}
