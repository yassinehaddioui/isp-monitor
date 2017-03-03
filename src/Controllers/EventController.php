<?php


namespace IspMonitor\Controllers;


use IspMonitor\Models\EventFilter;
use IspMonitor\Services\EventService;
use Slim\Http\Request;
use Slim\Http\Response;

class EventController extends BaseController
{
    /** @var  EventService $eventService */
    protected $eventService;
    const FILTER_CLASS = 'EventFilter';


    /**
     * EventController constructor.
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }


    public function getEvents(Request $request, Response $response, $args)
    {
        $filter = $this->getFilter($request, static::FILTER_CLASS);
        return $this->jsonDataResponse($response, $this->eventService->getEvents($filter), ['filter'    =>  $filter]);
    }

    public function createEvent(Request $request, Response $response) {

    }

    public function getEvent(Request $request, Response $response, $args)
    {
        $eventId = $args['id'];
        return $this->jsonDataResponse($response, $this->eventService->getEvent($eventId));

    }
}