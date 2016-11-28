<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 12:05 AM
 */

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;

class BaseController
{
    protected $ci;
    //Constructor
    public function __construct(ContainerInterface $ci) {
        $this->ci = $ci;
    }
}