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

class IndexController extends BaseController
{
    public function getIndex(Request $request, Response $response, $args) {
        // Render index view
        return $this->ci->get('renderer')->render($response, 'index.phtml', $args);
    }
}