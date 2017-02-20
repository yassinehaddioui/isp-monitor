<?php


namespace IspMonitor\Controllers;

use Doctrine\Instantiator\Exception\InvalidArgumentException;
use IspMonitor\Services\CachingService;
use Slim\Http\Request;
use Slim\Http\Response;
use Sumeko\Http\Exception\BadRequestException;

class CacheController extends BaseController
{
    /**
     * @var CachingService
     */
    private $cachingService;

    /**
     * CacheController constructor.
     * @param CachingService $cachingService
     */
    public function __construct(CachingService $cachingService)
    {
        $this->cachingService = $cachingService;
    }

    /**
     * Gets data from the cache.
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws BadRequestException
     */

    public function getData(Request $request, Response $response, $args)
    {
        try {
            return $this->jsonDataResponse($response, $this->cachingService->get($args['key']));
        } catch (InvalidArgumentException $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

    /**
     * Saves data in the cache.
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return Response
     * @throws BadRequestException
     */
    public function setData(Request $request, Response $response, $args)
    {
        try {
            $key = $args['key'];
            $ttl = $request->getParam('ttl') ?: 0;
            $data = $request->getParam('data');
            return $this->jsonDataResponse($response, $this->cachingService->set($key, $data, $ttl));
        } catch (InvalidArgumentException $e) {
            throw new BadRequestException($e->getMessage());
        }
    }

}