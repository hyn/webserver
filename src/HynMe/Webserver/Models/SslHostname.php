<?php namespace HynMe\Webserver\Models;

use HynMe\MultiTenant\Abstracts\Models\SystemModel;

class SslHostname extends SystemModel
{
    /**
     * @return SslCertificate
     */
    public function certificate()
    {
        return $this->belongsTo(SslCertificate::class);
    }
}