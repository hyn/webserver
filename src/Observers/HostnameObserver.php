<?php namespace Hyn\Webserver\Observers;

use Hyn\Webserver\Helpers\LetsEncryptHelper;

class HostnameObserver
{
    /**
     * @param $model
     */
    public function saved($model)
    {
        if (!$model->certificate) {
            (new LetsEncryptHelper($model))->generate();
        }
    }
}