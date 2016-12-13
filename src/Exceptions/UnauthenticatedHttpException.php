<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/12/16
 * Time: 11:29 PM
 */

namespace IspMonitor\Exceptions;


class UnauthenticatedHttpException extends \Exception
{
    protected $code = 401;
    protected $message = 'Unauthenticated.';
}