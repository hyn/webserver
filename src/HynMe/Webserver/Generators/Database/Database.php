<?php namespace HynMe\Webserver\Generators\Database;

use HynMe\MultiTenant\Models\Website;
use HynMe\Webserver\Abstracts\AbstractGenerator;
use DB;

class Database extends AbstractGenerator
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
     * @return string
     */
    public function name()
    {
        return sprintf("%d-%s", $this->website->id, $this->website->identifier);
    }

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function onRename($from, $to)
    {
        // TODO: Implement onRename() method.
    }

    /**
     * @return bool
     */
    public function onCreate()
    {
        DB::raw("CREATE DATABASE {$this->name()}");
    }

    /**
     * @return bool
     */
    public function onUpdate()
    {
        // TODO: Implement onUpdate() method.
    }

    /**
     * @return bool
     */
    public function onDelete()
    {
        DB::raw("DROP DATABASE {$this->name()}");
    }
}