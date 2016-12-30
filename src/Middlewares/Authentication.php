<?php


namespace IspMonitor\Middlewares;


use IspMonitor\Interfaces\AuthService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sumeko\Http\Exception\UnauthorizedException;


class Authentication extends BaseMiddleware
{


    /**
     * @var AuthService
     */
    private $authService;

    /**
     * Authentication constructor.
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return mixed
     * @throws UnauthorizedException
     */

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if (!$this->authService->isAuthorized($request)) {
            throw new UnauthorizedException();
        }
        return $next($request, $response);
    }
}