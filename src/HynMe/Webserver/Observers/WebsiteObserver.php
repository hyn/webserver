<?php namespace HynMe\Webserver\Observers;

use App;
use HynMe\Webserver\Commands\WebserverCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;

class WebsiteObserver
{
    use DispatchesCommands;

    public function created($model)
    {
        $this->dispatch(
            new WebserverCommand($model->id, 'create')
        );
    }

    public function updated($model)
    {
        $this->dispatch(
            new WebserverCommand($model->id, 'update')
        );
    }

    public function deleting($model)
    {
        $this->dispatch(
            new WebserverCommand($model->id, 'delete')
        );
    }
}