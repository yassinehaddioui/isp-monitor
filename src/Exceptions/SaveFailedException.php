<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/25/17
 * Time: 9:04 PM
 */

namespace IspMonitor\Exceptions;


use Sumeko\Http\Exception\InternalServerErrorException;

class SaveFailedException extends InternalServerErrorException
{
    protected $message = 'Save failed.';
}