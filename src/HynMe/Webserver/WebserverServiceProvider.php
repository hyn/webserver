<?php namespace HynMe\Webserver;

use HynMe\MultiTenant\Models\Website;
use Illuminate\Support\ServiceProvider;

class WebserverServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    public function boot()
    {

        // configuration
        $this->mergeConfigFrom(__DIR__.'/../../config/webserver.php', 'webserver');
        // adds views
        $this->loadViewsFrom(__DIR__.'/../../views', 'webserver');
        // migrations
        $this->publishes([__DIR__.'/../../migrations/' => database_path('/migrations')], 'migrations');

        Website::observe(new Observers\WebsiteObserver);
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
