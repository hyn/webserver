<?php namespace HynMe\Webserver\Generators\Webserver;

use Config, File;
use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Contracts\WebserverContract;

class Fpm implements WebserverContract
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
        return File::put(sprintf("%s%d-%s.conf", Config::get('webserver.paths.fpm'), $this->website->id, $this->website->present()->urlName), $this->generate());
    }

    protected function generate()
    {
        return view('webserver::webserver.fpm.configuration', [
            'website'=>$this->website,
            'base_path' => base_path(),
            'user'=>get_current_user(),
            'group'=>get_current_user()
        ]);
    }

    public function __toString()
    {
        return (string) $this->generate();
    }
}