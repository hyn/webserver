<?php namespace HynMe\Webserver\Helpers;

use File;

/**
 * Class ServerConfigurationHelper
 * @package HynMe\Webserver\Helpers
 */
class ServerConfigurationHelper
{
    /**
     * current user under which process is running
     * @return string
     */
    public function currentUser()
    {
        return function_exists('posix_getuid') && posix_getuid() == 0 ? 'root' : get_current_user();
    }

    /**
     * Creates directories if not yet existing
     * Generated for any configured service in config
     */
    public function createDirectories()
    {
        foreach(config('webserver') as $key => $params)
        {
            $path = array_get($params, 'path');

            if($path && !File::isDirectory($path))
                File::makeDirectory($path, 0755, true);
        }
    }
}