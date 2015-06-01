<?php namespace HynMe\Webserver\Repositories;

use HynMe\Framework\Repositories\BaseRepository;
use HynMe\MultiTenant\Models\Hostname;
use HynMe\Webserver\Contracts\SslRepositoryContract;

class SslRepository extends BaseRepository implements SslRepositoryContract
{
    /**
     * @param Hostname $hostname
     * @return \HynMe\Webserver\Models\SslCertificate
     */
    public function findByHostname(Hostname $hostname)
    {
        // TODO: Implement findByHostname() method.
    }
}