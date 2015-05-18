<?php namespace HynMe\Webserver\Generators\Webserver;

use Config, File;
use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Contracts\WebserverContract;
use HynMe\Webserver\Generators\AbstractGenerator;

class Fpm extends AbstractGenerator implements WebserverContract
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

    public function generate()
    {
        return view('webserver::webserver.fpm.configuration', [
            'website'=>$this->website,
            'base_path' => base_path(),
            'user'=>get_current_user(),
            'group'=>get_current_user()
        ]);
    }

    /**
     * Provides the complete path to publish the generated content to
     * @return string
     */
    protected function publishPath()
    {
        return sprintf("%s%d-%s.conf", Config::get('webserver.paths.fpm'), $this->website->id, $this->website->present()->urlName);
    }
}