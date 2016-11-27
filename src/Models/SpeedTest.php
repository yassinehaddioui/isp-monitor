<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/26/16
 * Time: 11:17 PM
 */

namespace IspMonitor\Models;


class SpeedTest extends BaseSerializableModel
{
    protected $uploadSpeed;
    protected $downloadSpeed;
    protected $length;
    protected $fileSize;
    protected $server;

    /**
     * SpeedTest constructor.
     * @param StreamSpeed $uploadSpeed
     * @param StreamSpeed $downloadSpeed
     */
    public function __construct(StreamSpeed $uploadSpeed,StreamSpeed $downloadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;
        $this->downloadSpeed = $downloadSpeed;
    }

    /**
     * @return StreamSpeed
     */
    public function getUploadSpeed()
    {
        return $this->uploadSpeed;
    }

    /**
     * @param StreamSpeed $uploadSpeed
     */
    public function setUploadSpeed($uploadSpeed)
    {
        $this->uploadSpeed = $uploadSpeed;
    }

    /**
     * @return StreamSpeed
     */
    public function getDownloadSpeed()
    {
        return $this->downloadSpeed;
    }

    /**
     * @param StreamSpeed $downloadSpeed
     */
    public function setDownloadSpeed($downloadSpeed)
    {
        $this->downloadSpeed = $downloadSpeed;
    }

    /**
     * @return mixed
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * @param mixed $fileSize
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = $fileSize;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }



}