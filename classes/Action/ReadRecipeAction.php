<?php

namespace Cookbook\Action;

use PDO;
use Slim\Http\Request;
use Slim\Http\Response;

class ReadRecipeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        $recipeId = (int)$request->getAttribute('recipe-id', 0);

        if ($recipeId > 0) {
            $recipe = $this->readRecipe($recipeId);
            if (!empty($recipe)) {
                $category = $this->readCategory($recipe['category_id']);
                if (!empty($category)) {
                    return $this->render($response, "recipe/view.php", [
                        'pageTitle' => $recipe['name'],
                        'categoryName' => $category['name'],
                        'recipe' => $recipe
                    ]);
                }
            }
        }

        return $response->withRedirect('/');
    }
}
