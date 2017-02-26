<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 12:55 AM
 */

namespace IspMonitor\Exceptions;


use Sumeko\Http\Exception\ConflictException;


class ReservationAlreadyMadeException extends ConflictException
{
    protected $message = 'Reservation already made.';
}