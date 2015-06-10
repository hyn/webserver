<?php namespace HynMe\Webserver\Generators;

use HynMe\MultiTenant\Models\Website;
use File;
use HynMe\Webserver\Abstracts\AbstractGenerator;
use Config;

abstract class AbstractFileGenerator extends AbstractGenerator
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
    /**
     * Writes the contents to disk
     * @return int
     */
    public function onCreate()
    {
        // take no action with no hostnames
        if($this->website->hostnames->count() == 0)
            return;
        return File::put(
            $this->publishPath(),
            $this->generate()->render(),
            true
        ) && $this->serviceReload();
    }

    public function onUpdate()
    {
        if($this->website->isDirty('identifier'))
        {
            $new = $this->website->identifier;

            $this->website->identifier = $this->website->getOriginal('identifier');
            $this->onDelete();
            $this->website->identifier = $new;
        }

        return $this->onCreate();
    }

    public function onRename($from, $to)
    {
        // .. no implementation
    }

    public function onDelete()
    {
        return File::delete($this->publishPath()) && $this->serviceReload();
    }

    public function name()
    {
        return sprintf("%d-%s", $this->website->id, $this->website->identifier);
    }

    /**
     * Generates the content
     * @return \Illuminate\View\View
     */
    abstract public function generate();
    /**
     * Provides the complete path to publish the generated content to
     * @return string
     */
    abstract protected function publishPath();

    /**
     * Reloads service if possible
     * @return bool
     */
    abstract protected function serviceReload();

    protected function baseName()
    {
        $name = basename(__CLASS__);
        $name = strtolower($name);
        return $name;
    }

    /**
     * Loads possible configuration from config file
     * @return mixed
     */
    public function configuration()
    {
        return Config::get('webserver::'. $this->baseName(), []);
    }

    /**
     * tests whether a certain service is installed
     * @return bool
     */
    public function isInstalled()
    {
        $service = array_get($this->configuration(), 'service');
        return $service && File::exists($service);
    }

    /**
     * Registers the service
     */
    public function register()
    {
        // create a unique filename for the global include directory
        $webserviceFileLocation = sprintf("%s%s",
            array_get($this->configuration(), "conf"),
            sprintf(array_get($this->configuration(), "mask", "%s"), substr(md5(env('APP_KEY')), 0, 10))
        );

        // load the tenant include path
        $targetPath = Config::get("webserver::paths.{$this->baseName()}");

        // save file to global include path
        File::put($webserviceFileLocation, sprintf(array_get($this->configuration(), "include"), $targetPath));

        /*
         * Register any depending services as well
         */
        $depends = array_get($this->configuration(), 'depends', []);

        foreach($depends as $depend)
        {
            $class = Config::get("webserver::{$depend}.class");
            (new $class)->register();
        }

        // reload any services
        if(method_exists($this, 'serviceReload'))
            $this->serviceReload();
    }
}