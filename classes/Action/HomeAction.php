<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        return $this->render($response, "home.php", [
            'pageTitle' => 'Dobrodošli na Cookbook'
        ]);
    }
}
