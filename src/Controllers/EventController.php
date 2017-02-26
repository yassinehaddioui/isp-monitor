<?php


namespace IspMonitor\Controllers;


use IspMonitor\Services\EventService;
use Slim\Http\Request;
use Slim\Http\Response;

class EventController extends BaseController
{
    /** @var  EventService $eventService */
    protected $eventService;

    public function getEvents(Request $request, Response $response, $args)
    {
        
    }
}