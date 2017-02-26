<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 12:54 AM
 */

namespace IspMonitor\Exceptions;


use Sumeko\Http\Exception\InternalServerErrorException;

class EventClosedException extends InternalServerErrorException
{
    protected $message = 'Event is closed, expired or full.';
}