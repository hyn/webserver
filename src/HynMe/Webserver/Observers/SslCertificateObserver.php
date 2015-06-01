<?php namespace HynMe\Webserver\Observers;

use HynMe\Webserver\Models\SslHostname;
use Illuminate\Foundation\Bus\DispatchesCommands;
use HynMe\Webserver\Commands\SslCertificateCommand;

class SslCertificateObserver
{
    use DispatchesCommands;

    /**
     * @param \HynMe\Webserver\Models\SslCertificate $model
     */
    public function creating($model)
    {
        if($model->x509)
        {
            $model->validates_at = $model->x509->getValidityFrom();
            $model->invalidates_at = $model->x509->getValidityTo();
            $model->wildcard = $model->x509->isWildcard();
        }
    }

    /**
     * @param \HynMe\Webserver\Models\SslCertificate $model
     */
    public function created($model)
    {
        if($model->x509)
        {
            foreach($model->x509->getHostnames() as $hostname)
            {
                $sslHostname = new SslHostname();
                $sslHostname->ssl_certificate_id = $model->id;
                $sslHostname->hostname = $hostname;
                $sslHostname->save();
            }
        }
        $this->dispatch(
            new SslCertificateCommand($model->id, 'create')
        );
    }

    public function updated($model)
    {
        $this->dispatch(
            new SslCertificateCommand($model->id, 'update')
        );
    }

    public function deleting($model)
    {
        $this->dispatch(
            new SslCertificateCommand($model->id, 'delete')
        );
    }
}