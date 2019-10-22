<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class DeleteRecipeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        $recipeId = (int)$request->getAttribute('recipe-id', 0);

        if ($recipeId > 0) {
            $db = $this->getDb();
            $statement = $db->prepare("DELETE FROM recipes WHERE id = :id");
            $statement->execute([':id' => $recipeId]);
        }

        return $response->withRedirect('/');
    }
}
