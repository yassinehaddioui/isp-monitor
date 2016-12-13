<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/12/16
 * Time: 10:25 PM
 */

namespace IspMonitor\Services;


use Psr\Http\Message\ServerRequestInterface;

class AuthService implements \IspMonitor\Interfaces\AuthService
{
    /**
     * @var string $apiKey
     */
    protected $apiKey;

    /**
     * AuthService constructor.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        if (!$apiKey)
            throw new \InvalidArgumentException('Missing API Key for Auth Service.', 500);
        $this->apiKey = $apiKey;
    }


    public function authenticate(ServerRequestInterface $request)
    {
        $authHeader = $request->getHeader('Authorization');
        if ($authHeader && $authHeader[0] === $this->apiKey)
            return true;
        return false;
    }
}