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
    /**
     * Returns true if the user is authorized, false otherwise.
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isAuthorized(ServerRequestInterface $request);
}