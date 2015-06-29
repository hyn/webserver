<?php namespace HynMe\Webserver\Commands;

use Illuminate\Console\Command;

use App;

use Illuminate\Commands\Command;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use HynMe\Webserver\Generators\Database\Database;
use HynMe\Webserver\Generators\Webserver\Fpm;
use HynMe\Webserver\Generators\Webserver\Nginx;
use HynMe\Webserver\Generators\Webserver\Ssl;
use HynMe\Webserver\Generators\Webserver\Apache;
use HynMe\Webserver\Generators\Unix\WebsiteUser;

class WebserverCommand extends Command implements SelfHandling, ShouldBeQueued {

	use
        InteractsWithQueue;

    /**
     * @var Website
     */
    protected $website;

    /**
     * @var string
     */
    protected $action;

    /**
     * Create a new command instance.
     *
     * @param int                       $website_id
     * @param string                    $action
     */
	public function __construct($website_id, $action = 'update')
	{
		$this->website = App::make('HynMe\MultiTenant\Contracts\WebsiteRepositoryContract')->findById($website_id);
        $this->action = $action;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
        if(!in_array($this->action, ['create', 'update', 'delete']))
            return;

        $action = sprintf("on%s", ucfirst($this->action));

        foreach($this->website->hostnamesWithCertificate as $hostname)
        {
            (new Ssl($hostname->certificate))->onUpdate();
        }

        (new WebsiteUser($this->website))->{$action}();
        (new Apache($this->website))->{$action}();
        (new Nginx($this->website))->{$action}();
        (new Fpm($this->website))->{$action}();

        (new Database($this->website))->{$action}();
	}

}
