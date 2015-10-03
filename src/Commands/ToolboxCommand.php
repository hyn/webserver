<?php namespace Hyn\Webserver\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Laraflock\MultiTenant\Contracts\WebsiteRepositoryContract;

class ToolboxCommand extends Command {

    use DispatchesJobs;

    protected $signature = 'webserver:toolbox
        {--update-configs : Update webserver configuration files}';

    /**
     * @var WebsiteRepositoryContract
     */
    protected $website;

    /**
     * @param WebsiteRepositoryContract $website
     */
    public function __construct(WebsiteRepositoryContract $website) {
        $this->website = $website;

        parent::__construct();
    }

    /**
     * Handles command execution
     */
    public function handle() {

        $this->website->queryBuilder()->chunk(50, function($websites) {
            foreach($websites as $website) {
                if($this->option('update-configs')) {
                    $this->dispatch(new WebserverCommand($website->id, 'update'));
                }
            }
        });
    }
}