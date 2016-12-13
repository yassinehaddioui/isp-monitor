<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 5:51 PM
 */

namespace IspMonitor\Exceptions;


use Exception;

class SpeedTestTimeOutException extends \HttpException
{
    protected $code = 408;

}