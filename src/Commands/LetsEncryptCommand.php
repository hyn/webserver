<?php namespace Hyn\Webserver\Commands;

use App;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;

class LetsEncryptCommand extends Command implements SelfHandling, ShouldBeQueued
{
    use
        InteractsWithQueue;

    /**
     * @var Certificate
     */
    protected $certificate;

    /**
     * @var string
     */
    protected $action;

    /**
     * Create a new command instance.
     *
     * @param        $hostname_id
     */
    public function __construct($hostname_id)
    {
        $this->hostname = app('Hyn\Webserver\Contracts\HostnameRepositoryContract')->findById($hostname_id);
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        (new LetsEncryptHelper($this->hostname))->generate();
    }
}