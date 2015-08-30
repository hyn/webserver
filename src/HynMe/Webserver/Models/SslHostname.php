<?php

namespace HynMe\Webserver\Models;

use Laracasts\Presenter\PresentableTrait;
use Laraflock\MultiTenant\Abstracts\Models\SystemModel;

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
