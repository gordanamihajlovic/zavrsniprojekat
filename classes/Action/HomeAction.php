<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        $recipes = $this->readRecipes();

        return $this->render($response, "list.php", [
            'pageTitle' => 'Svi recepti',
            'recipes' => $recipes
        ]);
    }
}
