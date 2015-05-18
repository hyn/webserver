<?php namespace HynMe\Webserver\Commands;

use App\Commands\Command;

use HynMe\MultiTenant\Models\Website;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use HynMe\Webserver\Generators\Webserver\Fpm;
use HynMe\Webserver\Generators\Webserver\Nginx;

class WebserverCommand extends Command implements SelfHandling, ShouldBeQueued {

	use
        InteractsWithQueue,
        SerializesModels;

    /**
     * @var Website
     */
    protected $website;
	/**
	 * Create a new command instance.
	 *
     * @param Website $website
	 */
	public function __construct(Website $website)
	{
		$this->website = $website;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{

        (new Nginx($this->website))->write();
        (new Fpm($this->website))->write();
	}

}
