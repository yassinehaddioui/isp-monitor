<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 11/27/16
 * Time: 12:06 AM
 */

namespace IspMonitor\Controllers;

use Interop\Container\ContainerInterface;
use IspMonitor\Services\RecordingService;
use Slim\Http\Request;
use Slim\Http\Response;
use IspMonitor\Interfaces\SpeedTestService;


class SpeedTestController extends BaseController
{
    /**
     * @var SpeedTestService
     */
    private $speedTestService;

    /**
     * @var RecordingService
     */
    private $recordingService;

    const DB_NAME = 'speedtest';
    const COLLECTION_NAME = 'logs';
    const GET_LOGS_DEFAULT_LIMIT = 1000;

    /**
     * SpeedTestController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /** Performs a Speed test and returns a response with the result.
     * Optionally saves the data to the DB.
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function getSpeed(Request $request, Response $response)
    {
        $service = $this->getSpeedTestService();
        if ($testUrl = $request->getParam('testUrl'))
            $service->setTestUrl($testUrl);
        if ($timeout = $request->getParam('timeout'))
            $service->setTimeout($timeout);
        $data = $service->speedTest();
        if ($save = $request->getParam('save')) {
            $recordingService = $this->getRecordingService();
            $recordingService->insertOne($data, static::DB_NAME, static::COLLECTION_NAME);
        }
        $meta = ['saved' => $save ? 1 : 0];
        return $this->jsonDataResponse($response, $data, $meta);
    }

    /**
     * Returns a list of logs.
     * @param Request $request
     * @param Response $response
     * @return Response
     */

    public function getResults(Request $request, Response $response)
    {
        $recordingService = $this->getRecordingService();
        $limit = $request->getParam('limit') ?: self::GET_LOGS_DEFAULT_LIMIT;
        $options = ["sort" => ["timestamp" => -1], "limit" => intval($limit)];
        $collection = $recordingService->getCollection(static::DB_NAME, static::COLLECTION_NAME);
        $data = $collection->find([], $options)->toArray();
        $meta = ['options'  =>  $options];
        return $this->jsonDataResponse($response, $data, $meta);
    }

    /**
     * Extracts the speed test service from the container.
     * @return SpeedTestService
     */
    protected function getSpeedTestService()
    {
        if (empty($this->speedTestService))
            $this->speedTestService = $this->container->get('speedTestService');
        return $this->speedTestService;
    }

    /**
     * Extracts the Recording Service from the container.
     * @return RecordingService
     */
    protected function getRecordingService()
    {
        if (empty($this->recordingService))
            $this->recordingService = $this->container->get('recordingService');
        return $this->recordingService;
    }
}