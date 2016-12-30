<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/26/16
 * Time: 7:05 PM
 */

namespace IspMonitor\Models;


use IspMonitor\Models\Base\BaseSerializableModel;

class ExceptionResponse extends BaseSerializableModel
{
    /**
     * @var int $statusCode
     */
    protected $statusCode;
    /**
     * @var string $message
     */
    protected $message;
    /**
     * @var bool $error
     */
    protected $error = true;

    /**
     * ExceptionResponse constructor.
     * @param int $statusCode
     * @param string $message
     */
    public function __construct($statusCode, $message)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return boolean
     */
    public function isError()
    {
        return $this->error;
    }

}