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

    /**
     * @return string
     */
    public function getTestUrl();

    /**
     * @param string $testUrl
     * @return SpeedTestService
     */
    public function setTestUrl($testUrl);

    /**
     * @return int
     */
    public function getTimeout();

    /**
     * @param int $timeout
     * @return SpeedTestService
     */
    public function setTimeout($timeout);

}