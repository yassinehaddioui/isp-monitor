<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 4:44 PM
 */

namespace IspMonitor\Services;

use IspMonitor\Exceptions\SpeedTestTimeOutException;
use IspMonitor\Models\SpeedTest;
use IspMonitor\Models\fValueUnit;

/**
 * Class SpeedTestService
 * @package IspMonitor\Services
 * Useful speedtest servers list: http://www.speedtest.net/speedtest-servers.php
 */
class SpeedTestService
{
    const DEFAULT_TEST_URL = 'http://speedtest2.verticalbroadband.com/speedtest/random750x750.jpg';
    const DEFAULT_TIMEOUT = 20;
    const CONNECT_TIMEOUT = 5;
    const TIME_PRECISION = 4;
    const DEFAULT_FORMAT_BYTES_PRECISION = 2;

    protected $timeout;
    protected $testUrl;

    /**
     * SpeedTestService constructor.
     * @param $timeout
     * @param $testUrl
     */
    public function __construct($timeout = self::DEFAULT_TIMEOUT, $testUrl = self::DEFAULT_TEST_URL)
    {
        $this->timeout = $timeout;
        $this->testUrl = $testUrl;
    }

    /**
     * @return SpeedTest
     */
    public function speedTest()
    {
        return $this->downloadSpeedTest();
    }

    private function downloadSpeedTest(){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->testUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, static::CONNECT_TIMEOUT);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        $time_start = microtime(true);
        $data = curl_exec($ch);
        $total_time = new fValueUnit(round(microtime(true) - $time_start, static::TIME_PRECISION), 's');
        if ($err = curl_errno($ch)) {
            curl_close($ch);
            if ($err == CURLE_OPERATION_TIMEOUTED)
                throw new SpeedTestTimeOutException();
            else
                throw new \Exception('cURL problem. Code:' . $err);
        }
        curl_close($ch);

        $size = new fValueUnit(null, null, $this->formatBytes($actualSize = strlen($data)));
        $speed = new fValueUnit(null, null, $this->formatBytes(round($actualSize / $total_time->getValue(), 0)) . '/s');
        $result = new SpeedTest($speed, $total_time, $size, $this->testUrl, $this->timeout);
        return $result;
    }
    private function formatBytes($size, $precision = self::DEFAULT_FORMAT_BYTES_PRECISION)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }

}