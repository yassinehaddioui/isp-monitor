<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 6:28 PM
 */

namespace IspMonitor\Interfaces;

use IspMonitor\Models\SpeedTest;

interface SpeedTestService
{
    /**
     * SpeedTestService constructor.
     * @param int $timeout
     * @param string $testUrl
     */
    public function __construct($timeout, $testUrl);

    /**
     * @return SpeedTest
     */
    public function speedTest();
}