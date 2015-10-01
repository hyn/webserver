<?php

namespace Hyn\Webserver\Commands;

use Hyn\Webserver\Generators\Database\Database;
use Hyn\Webserver\Generators\Unix\WebsiteUser;
use Hyn\Webserver\Generators\Webserver\Apache;
use Hyn\Webserver\Generators\Webserver\Fpm;
use Hyn\Webserver\Generators\Webserver\Nginx;
use Hyn\Webserver\Generators\Webserver\Ssl;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class WebserverCommand extends Command implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue;

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
     * @param int    $website_id
     * @param string $action
     */
    public function __construct($website_id, $action = 'update')
    {
        $this->website = app('Laraflock\MultiTenant\Contracts\WebsiteRepositoryContract')->findById($website_id);
        $this->action = $action;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if (! in_array($this->action, ['create', 'update', 'delete'])) {
            return;
        }

        $action = sprintf('on%s', ucfirst($this->action));

        foreach ($this->website->hostnamesWithCertificate as $hostname) {
            (new Ssl($hostname->certificate))->onUpdate();
        }

        (new WebsiteUser($this->website))->{$action}();
        (new Apache($this->website))->{$action}();
        (new Nginx($this->website))->{$action}();
        (new Fpm($this->website))->{$action}();

        (new Database($this->website))->{$action}();
    }
}
