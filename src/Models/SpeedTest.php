<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/26/16
 * Time: 11:17 PM
 */

namespace IspMonitor\Models;

use IspMonitor\Models\Base\BaseSerializableModel;


class SpeedTest extends BaseSerializableModel
{
    protected $downloadSpeed;
    protected $timeElapsed;
    protected $fileSize;
    protected $url;
    protected $timeout;

    /**
     * SpeedTest constructor.
     * @param fValueUnit $downloadSpeed
     * @param fValueUnit $timeElapsed
     * @param fValueUnit $fileSize
     * @param string $url
     * @param int $timeout
     */
    public function __construct($downloadSpeed, $timeElapsed, $fileSize, $url, $timeout)
    {
        $this->downloadSpeed = $downloadSpeed;
        $this->timeElapsed = $timeElapsed;
        $this->fileSize = $fileSize;
        $this->url = $url;
        $this->timeout = $timeout;
    }

    /**
     * @return fValueUnit
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * @param fValueUnit $downloadSpeed
     * @return SpeedTest
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;
        return $this;
    }

    /**
     * @return fValueUnit
     */
    public function getTimeElapsed()
    {
        return $this->timeElapsed;
    }

    /**
     * @param fValueUnit $timeElapsed
     * @return SpeedTest
     */
    public function setTimeElapsed($timeElapsed)
    {
        $this->timeElapsed = $timeElapsed;
        return $this;
    }

    /**
     * @return fValueUnit
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param fValueUnit $fileSize
     * @return SpeedTest
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return SpeedTest
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return SpeedTest
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }




}