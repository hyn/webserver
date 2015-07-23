<?php namespace HynMe\Webserver;

use Laraflock\MultiTenant\Models\Website;
use HynMe\Webserver\Models\SslCertificate;
use HynMe\Webserver\Models\SslHostname;
use HynMe\Webserver\Repositories\SslRepository;
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
        SslCertificate::observe(new Observers\SslCertificateObserver);

        /*
         * Ssl repository
         */
        $this->app->bind('HynMe\Webserver\Contracts\SslRepositoryContract', function($app)
        {
            return new SslRepository(new SslCertificate, new SslHostname());
        });
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
