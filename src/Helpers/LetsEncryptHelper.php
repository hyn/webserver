<?php namespace Hyn\Webserver\Helpers;

use File;
use Hyn\LetsEncrypt\Resources\Account;
use Hyn\LetsEncrypt\Storages\Configuration\DiskStorage;
use Hyn\MultiTenant\Models\Hostname;
use Hyn\LetsEncrypt\Resources\Certificate;
use Hyn\MultiTenant\Models\Tenant;

class LetsEncryptHelper
{

    /**
     * @var Hostname
     */
    protected $hostname;

    /**
     * @var Tenant
     */
    protected $contact;


    public function __construct(Hostname $hostname)
    {
        $this->hostname = $hostname;

        $this->contact = config('webserver.ssl.lets-encrypt-contact');

        $this->directory = sprintf('%s/%s', config('webserver.ssl.lets-encrypt-storage-path'),
            array_get($this->contact, 'username'));
    }

    /**
     * Checks whether the installation allows for Let's Encrypt certificates.
     *
     * @return bool
     */
    protected function checkInstallation()
    {
        if (config('webserver.ssl.lets-encrypt') && class_exists(Certificate::class) &&
            !empty($this->contact['username']) && !empty($this->contact['email-address']) &&
            (File::isDirectory($this->directory) || File::makeDirectory($this->directory, 0755, true))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Generates the Let's Encrypt certificate.
     *
     * @return bool|mixed
     */
    public function generate()
    {
        if (!$this->checkInstallation()) {
            return false;
        }

        $account     = new Account(array_get($this->contact, 'username'), array_get($this->contact, 'email-address'),
            new DiskStorage($this->directory));
        $certificate = (new Certificate($account))->addHostname($this->hostname->hostname);

        return $certificate->request();
    }
}