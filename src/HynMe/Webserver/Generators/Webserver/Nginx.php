<?php namespace HynMe\Webserver\Generators\Webserver;

use Config, File;
use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Generators\AbstractFileGenerator;

class Nginx extends AbstractFileGenerator
{

    /**
     * Generates the view that is written
     * @return \Illuminate\View\View
     */
    public function generate()
    {
        return view('webserver::webserver.nginx.configuration', [
            'website' => $this->website,
            'public_path' => public_path()
        ]);
    }

    /**
     * Provides the complete path to publish the generated content to
     * @return string
     */
    protected function publishPath()
    {
        return sprintf("%s%s.conf", Config::get('webserver.paths.nginx'), $this->name());
    }

    /**
     * Reloads service if possible
     *
     * @return bool
     */
    protected function serviceReload()
    {
        $ret = exec("nginx -t", $out, $state);

        if($state === 0)
            exec("service nginx reload", $out, $state);

        return true;
    }
}