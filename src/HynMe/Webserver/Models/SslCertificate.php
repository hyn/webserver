<?php

namespace HynMe\Webserver\Models;

use Config;
use HynMe\Webserver\Tools\CertificateParser;
use Laracasts\Presenter\PresentableTrait;
use Laraflock\MultiTenant\Abstracts\Models\SystemModel;

class SslCertificate extends SystemModel
{
    use PresentableTrait;

    protected $presenter = 'HynMe\Webserver\Presenters\SslCertificatePresenter';

    protected $fillable = ['tenant_id', 'certificate', 'authority_bundle'];

    protected $appends = ['pathKey', 'pathPem'];

    public function getDates()
    {
        return ['validates_at', 'invalidates_at'];
    }

    /**
     * @return CertificateParser|null
     */
    public function getX509Attribute()
    {
        return $this->certificate ? new CertificateParser($this->certificate) : null;
    }

    public function hostnames()
    {
        return $this->hasMany(SslHostname::class);
    }

    public function publishPath($postfix = 'key')
    {
        return sprintf('%s/%s/certificate.%s', Config::get('webserver.ssl.path'), $this->id, $postfix);
    }

    public function getPathKeyAttribute()
    {
        return $this->publishPath('key');
    }
    public function getPathPemAttribute()
    {
        return $this->publishPath('pem');
    }
}
