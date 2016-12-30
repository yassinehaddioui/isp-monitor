<?php
/**
 * Created by IntelliJ IDEA.
 * User: yassinehaddioui
 * Date: 12/3/16
 * Time: 9:25 PM
 */

namespace IspMonitor\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;

class IndexController extends BaseController
{
    /**
     * @var PhpRenderer
     */
    private $renderer;

    /**
     * IndexController constructor.
     * @param PhpRenderer $renderer
     */
    public function __construct(PhpRenderer $renderer)
    {
        $this->renderer = $renderer;
    }


    public function getIndex(Request $request, Response $response, $args) {
        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    }
}