<?php namespace HynMe\Webserver\Presenters;

use HynMe\Framework\Presenters\AbstractModelPresenter;

class SslCertificatePresenter extends AbstractModelPresenter
{
    /**
     * Shows summary of hostnames
     * @return string
     */
    public function hostnamesSummary()
    {
        $hostnames = $this->hostnames->lists('hostname');
        return implode(", ", array_splice($hostnames, 0, 5));
    }

    /**
     * @return int
     */
    public function additionalHostnames()
    {
        return count($this->hostnames) - 5;
    }

    /**
     * @return string
     */
    public function icon()
    {
        return 'lock';
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->id;
    }
    public function expiry()
    {
        return $this->invalidates_at->isPast() ? trans('management-interface::ssl.is_expired') : $this->invalidates_at->diffForHumans(null, true);
    }
}