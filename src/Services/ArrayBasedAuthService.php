<?php

namespace IspMonitor\Services;


use Psr\Http\Message\ServerRequestInterface;
use IspMonitor\Interfaces\AuthService;

/**
 * Very simple authorization service. Checks the "Authorization" header for the API key set in the config.
 * Class AuthService
 * @package IspMonitor\Services
 */

class ArrayBasedAuthService implements AuthService
{
    /**
     * @var array $apiKeys
     */
    protected $apiKeys = [];

    const AUTH_HEADER = 'Authorization';
    const AUTH_GET_PARAM = 'apiKey';
    /**
     * AuthService constructor.
     * @param array $apiKeys
     * @throws \InvalidArgumentException
     */
    public function __construct($apiKeys)
    {
        if (empty($apiKeys))
            throw new \InvalidArgumentException('AuthService: API Keys array is required.', 500);
        $this->apiKeys = $apiKeys;
    }

    /**
     * Checks identity against allowed identities.
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isAuthorized(ServerRequestInterface $request)
    {
        $id = $this->getIdentity($request);
        if ($id && in_array($id, $this->apiKeys))
            return true;
        return false;
    }

    /**
     * Get identity from Authorization header OR GET parameter
     * @param ServerRequestInterface $request
     * @return string|null
     */
    public function getIdentity(ServerRequestInterface $request) {
        $authHeader = $request->getHeader(static::AUTH_HEADER);
        if (!empty($authHeader))
            return $authHeader[0];
        $queryParams = $request->getQueryParams();
        if (!empty($queryParams[static::AUTH_GET_PARAM]))
            return $queryParams[static::AUTH_GET_PARAM];
        return null;
    }
}
