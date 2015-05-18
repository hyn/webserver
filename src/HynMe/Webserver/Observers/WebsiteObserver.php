<?php namespace HynMe\Webserver\Observers;

use App, Queue;
use HynMe\Webserver\Commands\WebserverCommand;
use HynMe\Webserver\Generators\Webserver\Fpm;
use HynMe\Webserver\Generators\Webserver\Nginx;
use Illuminate\Foundation\Bus\DispatchesCommands;

class WebsiteObserver
{
    use DispatchesCommands;

    protected function saveConfigurations($model)
    {
        // use queue if available
        if(Queue::connected())
            $this->dispatch(
                new WebserverCommand($model)
            );
        else {
            (new Nginx($model))->write();
            (new Fpm($model))->write();

        }
    }

    public function saved($model)
    {
        $this->saveConfigurations($model);
    }

    public function deleted($model)
    {
        $this->saveConfigurations($model);
    }
}