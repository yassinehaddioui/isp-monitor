<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/12/16
 * Time: 10:32 PM
 */

namespace IspMonitor\Middlewares;

use Interop\Container\ContainerInterface;

class BaseMiddleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * ServiceProvider constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}