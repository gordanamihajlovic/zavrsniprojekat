<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class CreateRecipeAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        // citanje podataka unesenih u formu iz requesta
        $data = $this->getFormData($request);

        // validacija poslatih podataka
        $invalidFormFields = $this->getInvalidFormFields($data);

        // redirekcija na formu za unos ako neki podaci nisu validni
        if (!empty($invalidFormFields)) {
            return $response->withRedirect('/recipe/form?' . urldecode(http_build_query([
                'invalid' => $invalidFormFields,
                'data' => $data
            ])));
        }

        // citanje sadrzaja uploadovane slike
        $imageContent = $this->getUploadedImage($request);

        // unos podataka recepta u bazu
        $db = $this->getDb();
        $sql = "INSERT INTO recipes (name, description, image, category_id, date_updated) 
            VALUES (:name, :description, :image, :category, :date)";
        $statement = $db->prepare($sql);
        $statement->execute([
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':image' => $imageContent,
            ':category' => $data['category_id'],
            ':date' => date("Y-m-d H:i:s")
        ]);
        $recipeId = $db->lastInsertId();

        return $response->withRedirect('/recipe/read/' . $recipeId);
    }
}
