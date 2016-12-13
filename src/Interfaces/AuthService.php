<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/12/16
 * Time: 10:14 PM
 */

namespace IspMonitor\Interfaces;

use \Psr\Http\Message\ServerRequestInterface;

interface AuthService
{
    public function authenticate(ServerRequestInterface $request);
}