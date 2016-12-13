<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/12/16
 * Time: 10:12 PM
 */

namespace IspMonitor\Middlewares;


use IspMonitor\Exceptions\UnauthenticatedHttpException;
use IspMonitor\Interfaces\AuthService;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sumeko\Http\Exception\UnauthorizedException;


class Authentication extends BaseMiddleware
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return mixed
     * @throws UnauthorizedException
     */

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        /** @var AuthService $authService */
        $authService = $this->container->get('authService');

        if (!$authService->authenticate($request)) {
            throw new UnauthorizedException();
        }
        return $next($request, $response);
    }
}