<?php

namespace HynMe\Webserver\Generators\Webserver;

use File;
use HynMe\Webserver\Abstracts\AbstractGenerator;
use HynMe\Webserver\Models\SslCertificate;

class Ssl extends AbstractGenerator
{
    /**
     * @var SslCertificate
     */
    protected $certificate;

    public function __construct(SslCertificate $certificate)
    {
        $this->certificate = $certificate;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->certificate->present()->name;
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     */
    public function onRename($from, $to)
    {
        // no action required
        return true;
    }

    /**
     * Publish path for specific filetype.
     *
     * @param string $postfix
     *
     * @return string
     */
    protected function publishPath($postfix = 'key')
    {
        return $this->certificate->publishPath($postfix);
    }

    /**
     * Pem.
     *
     * @return string
     */
    protected function pem()
    {
        return implode("\r\n", [$this->certificate->certificate, $this->certificate->authority_bundle]);
    }

    /**
     * @return bool
     */
    public function onCreate()
    {
        return
            (! File::isDirectory(dirname($this->publishPath('pem'))) && File::makeDirectory(dirname($this->publishPath('pem'))))
            && File::put($this->publishPath('key'), $this->certificate->key)
            && File::put($this->publishPath('pem'), $this->pem());
    }

    /**
     * @return bool
     */
    public function onUpdate()
    {
        $this->onCreate();
    }

    /**
     * @return bool
     */
    public function onDelete()
    {
        return
            File::delete($this->publishPath('key'))
            && File::delete($this->publishPath('pem'));
    }
}
