<?php

namespace Cookbook\Action;

use Slim\Http\Request;
use Slim\Http\Response;

class RecipeSearchAction extends BaseAction
{
    public function __invoke(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $searchTerm = isset($data['search']) ? trim($data['search']) : '';

        $recipes = [];
        $db = $this->getDb();
        $sql = "SELECT * FROM recipes ";
        if (!empty($searchTerm)) {
            $sql .= "WHERE name LIKE :term OR description LIKE :term ";
        }
        $sql .= "ORDER BY date_updated DESC";
        $statement = $db->prepare($sql);
        $statement->execute([':term' => "%$searchTerm%"]);
        $recipes = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $this->render($response, "list.php", [
            'pageTitle' => 'Rezultati pretrage za reč "' . $searchTerm . '"',
            'recipes' => $recipes
        ]);
    }
}
