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

        /*
         * Set configuration variables
         */
        $this->mergeConfigFrom(__DIR__.'/../../config/webserver.php', 'webserver');
        // adds views
        $this->loadViewsFrom(__DIR__.'/../../views', 'webserver');

        Website::observe(new Observers\WebsiteObserver);
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
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
