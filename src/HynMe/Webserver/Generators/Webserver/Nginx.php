<?php namespace HynMe\Webserver\Generators\Webserver;

use Config, File;
use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Contracts\WebserverContract;

class Nginx implements WebserverContract
{

    /**
     * @var Website
     */
    protected $website;

    /**
     * @param Website $website
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function write()
    {
        return File::put(sprintf("%s%d-%s.conf", Config::get('webserver.paths.nginx'), $this->website->id, $this->website->present()->urlName), $this->generate());
    }

    protected function generate()
    {
        return view('webserver::webserver.nginx.configuration', [
            'website'=>$this->website,
            'public_path' => public_path()
        ]);
    }

    public function __toString()
    {
        return (string) $this->generate();
    }
}