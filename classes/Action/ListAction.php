<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class ListAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        // identifikator kategorije poslat kao deo URL-a (url path)
        $categoryId = (int)$request->getAttribute('category-id', 0);

        $category = $this->readCategory($categoryId);
        $recipes = $this->readRecipes($categoryId);

        return $this->render($response, "list.php", [
            'pageTitle' => $category['name'],
            'recipes' => $recipes
        ]);
    }
}
