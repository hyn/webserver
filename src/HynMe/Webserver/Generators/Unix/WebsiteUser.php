<?php

namespace HynMe\Webserver\Generators\Unix;

use HynMe\Webserver\Generators\AbstractUserGenerator;
use Laraflock\MultiTenant\Models\Website;

class WebsiteUser extends AbstractUserGenerator
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
     * Creates the user on the service.
     *
     * @return bool
     */
    public function onCreate()
    {
        return exec(sprintf('adduser %s --home %s --no-create-home --disabled-password --disabled-login --gecos ""',
            $this->name(),
            base_path()));
    }

    /**
     * @return bool
     */
    public function onUpdate()
    {
        if ($this->website->isDirty('identifier')) {
            return $this->onRename($this->website->getOriginal('identifier'), $this->website->name());
        }
    }

    /**
     * Removes the user from the service.
     *
     * @return bool
     */
    public function onDelete()
    {
        return exec(sprintf('deluser %s', $this->name()));
    }

    /**
     * Unique username.
     *
     * @return string
     */
    public function name()
    {
        return $this->website->identifier;
    }

    /**
     * Renames a user.
     *
     * @return bool
     */
    public function onRename($from, $to)
    {
        return exec(sprintf('usermod -l %s %s', $to, $from));
    }
}
