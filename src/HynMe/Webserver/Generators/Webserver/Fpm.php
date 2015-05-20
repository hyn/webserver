<?php namespace HynMe\Webserver\Generators\Webserver;

use Config, File;
use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Generators\AbstractFileGenerator;

class Fpm extends AbstractFileGenerator
{

    /**
     * Generates the view that is written
     * @return \Illuminate\View\View
     */
    public function generate()
    {
        return view('webserver::webserver.fpm.configuration', [
            'website'   => $this->website,
            'base_path' => base_path(),
            'user'      => $this->website->identifier,
            'group'     => get_current_user()
        ]);
    }

    /**
     * Provides the complete path to publish the generated content to
     * @return string
     */
    protected function publishPath()
    {
        return sprintf("%s%s.conf", Config::get('webserver.paths.fpm'), $this->name());
    }
    /**
     * Reloads service if possible
     *
     * @return bool
     */
    protected function serviceReload()
    {
        $ret = exec("php5-fpm -t", $out, $state);

        if($state === 0)
            exec("service php5-fpm reload", $out, $state);

        return true;
    }
}