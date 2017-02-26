<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 2:11 PM
 */

namespace IspMonitor\Exceptions;


use Sumeko\Http\Exception\RequestTimeoutException;

class UnableToAcquireLockException extends RequestTimeoutException
{
    protected $message = 'Unable to acquire lock. Please try again.';
}