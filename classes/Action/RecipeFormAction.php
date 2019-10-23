<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use PDO;

class RecipeFormAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        // identifikator recepta poslat kao deo URL-a (url path)
        $recipeId = (int)$request->getAttribute('recipe-id', 0);
        // niz sa identifikatorima polja forme za unos recepta koja su obavezna a nisu popunjena
        $invalidFields = $request->getQueryParam('invalid', []);
        // podaci iz forme za unos recepta
        $data = $request->getQueryParam('data', []);

        $pageTitle = 'Unos novog recepta';
        $formAction = '/recipe/create';
        $buttonLabel = "Dodaj recept";

        $db = $this->getDb();
        $result = $db->query("SELECT * FROM categories ORDER BY name ASC");
        $categoryOptions = $result->fetchAll(PDO::FETCH_ASSOC);

        $recipe = [
            'id' => '',
            'name' => '',
            'category_id' => '',
            'description' => ''
        ];
        if ($recipeId > 0) {
            $recipe = $this->readRecipe($recipeId);
            if (!empty($recipe)) {
                $pageTitle = 'Izmena recepta ' . $recipe['name'];
            }
            $formAction = '/recipe/update';
            $buttonLabel = "Izmeni recept";
        }

        if (!empty($data)) {
            if (isset($data['name'])) {
                $recipe['name'] = $data['name'];
            }
            if (isset($data['description'])) {
                $recipe['description'] = $data['description'];
            }
            if (isset($data['category_id'])) {
                $recipe['category_id'] = (int)$data['category_id'];
            }
        }

        return $this->render($response, "recipe/form.php", [
            'pageTitle' => $pageTitle,
            'categoryOptions' => $categoryOptions,
            'recipe' => $recipe,
            'formAction' => $formAction,
            'invalidFields' => $invalidFields,
            'buttonLabel' => $buttonLabel
        ]);
    }
}
