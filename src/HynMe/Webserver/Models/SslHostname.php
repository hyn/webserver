<?php namespace HynMe\Webserver\Models;

use HynMe\MultiTenant\Abstracts\Models\SystemModel;
use Laracasts\Presenter\PresentableTrait;

class SslHostname extends SystemModel
{
    use PresentableTrait;

    protected $presenter = 'HynMe\Webserver\Presenters\SslHostnamePresenter';
    /**
     * @return SslCertificate
     */
    public function certificate()
    {
        return $this->belongsTo(SslCertificate::class);
    }
}