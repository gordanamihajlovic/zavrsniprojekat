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
                $db = $this->getDb();
                $statement = $db->prepare("SELECT * FROM categories WHERE id = :id");
                $statement->execute([':id' => $recipe['category_id']]);
                $category = $statement->fetch(PDO::FETCH_ASSOC);
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
