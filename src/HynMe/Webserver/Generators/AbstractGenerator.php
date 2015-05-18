<?php namespace HynMe\Webserver\Generators;

use File;
use Queue;

abstract class AbstractGenerator
{
    /**
     * Writes the contents to disk
     * @return int
     */
    public function write()
    {
        return File::put(
            $this->publishPath(),
            $this->generate()->render(),
            true
        );
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
}