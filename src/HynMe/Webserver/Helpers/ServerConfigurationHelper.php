<?php namespace HynMe\Webserver\Helpers;

use File;
use Illuminate\Support\Collection;

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
}