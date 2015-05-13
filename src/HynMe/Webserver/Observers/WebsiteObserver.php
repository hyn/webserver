<?php namespace HynMe\Webserver\Observers;

use App;
use HynMe\Webserver\Generators\Webserver\Fpm;
use HynMe\Webserver\Generators\Webserver\Nginx;

class WebsiteObserver
{

    public function creating($model)
    {
        $this->saveConfigurations($model);
    }

    protected function saveConfigurations($model)
    {
        (new Nginx($model))->write();
        (new Fpm($model))->write();
    }

    public function saving($model)
    {
        $this->saveConfigurations($model);
    }

    public function deleting($model)
    {
        $this->saveConfigurations($model);
    }
}