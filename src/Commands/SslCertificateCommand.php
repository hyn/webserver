<?php

namespace Hyn\Webserver\Commands;

use Hyn\Webserver\Generators\Webserver\Ssl;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Queue\InteractsWithQueue;

class SslCertificateCommand extends Command implements SelfHandling, ShouldBeQueued
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
     * @param int    $website_id
     * @param string $action
     */
    public function __construct($certificate_id, $action = 'update')
    {
        $this->certificate = app('Hyn\Webserver\Contracts\SslRepositoryContract')->findById($certificate_id);
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

        (new Ssl($this->certificate))->{$action}();
    }
}
