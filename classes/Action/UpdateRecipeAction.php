<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class UpdateRecipeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        // citanje podataka unesenih u formu iz requesta
        $data = $this->getFormData($request);
        $recipeId = !empty($data['id']) ? (int)$data['id'] : 0;

        // validacija poslatih podataka
        $invalidFormFields = $this->getInvalidFormFields($data);

        // redirekcija na formu za unos ako neki podaci nisu validni
        if (!empty($invalidFormFields)) {
            return $response->withRedirect("/recipe/form/$recipeId?" . urldecode(http_build_query([
                    'invalid' => $invalidFormFields,
                    'data' => $data
                ])));
        }

        if ($recipeId > 0) {
            // citanje sadrzaja uploadovane slike
            $imageContent = $this->getUploadedImage($request, $recipeId);

            // azuriranje podataka recepta u bazi
            $db = $this->getDb();
            $sql = "UPDATE recipes SET 
                name = :name,
                description = :description,
                image = :image,
                category_id = :category,
                date_updated = :date
                WHERE id = :id";
            $statement = $db->prepare($sql);
            $statement->execute([
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':image' => $imageContent,
                ':category' => $data['category_id'],
                ':date' => date("Y-m-d H:i:s"),
                ':id' => $recipeId
            ]);

            return $response->withRedirect('/recipe/read/' . $recipeId);
        }

        return $response->withRedirect('/');
    }
}
