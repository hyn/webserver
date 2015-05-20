<?php namespace HynMe\Webserver\Generators;

use HynMe\MultiTenant\Models\Website;
use File;
use HynMe\Webserver\Abstracts\AbstractGenerator;
use Queue;

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
}