<?php

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
use IspMonitor\Utilities\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use IspMonitor\Models\EventFilter;
use IspMonitor\Models\BaseFilter;

class BaseController
{

    const DEFAULT_LIST_LIMIT = 100;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface $container
     * @return BaseController
     */
    public function setContainer($container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @param Response $response
     * @param mixed $data
     * @param array $meta
     * @return Response
     */

    protected function jsonDataResponse(Response $response, $data, $meta = [])
    {
        $result = ['data' => $data];
        if (!empty($meta)) {
            $meta['appVersion'] = Environment::getPackageVersion();
            $result['meta'] = $meta;
        }
        return $response->withJson($result);
    }

    /**
     * @param Request $request
     * @param $class
     * @return BaseFilter|EventFilter
     */

    protected function getFilter(Request $request, $class = null)
    {
        $filter = new BaseFilter();
        $limit = $request->getQueryParam('limit') ?: null;
        $sortBy = $request->getQueryParam('sortBy') ?: null;
        $sortOrder = $request->getQueryParam('sortOrder') ?: null;
        $preset = $request->getQueryParam('preset') ?: null;

        switch ($class) {
            case 'EventFilter':
                $filter = new EventFilter();
                if ($preset)
                    $filter->setPreset($preset);
        }
        if ($limit)
            $filter->setLimit($limit);
        if ($sortBy)
            $filter->setSortBy($sortBy);
        if ($sortOrder)
            $filter->setSortOrder($sortOrder);

        return $filter;
    }

}