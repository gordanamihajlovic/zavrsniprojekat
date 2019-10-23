<?php

namespace Cookbook\Action;

use PDO;
use Slim\Container;
use Slim\Http\Request;
use Slim\Http\UploadedFile;

class BaseAction
{
    /**
     * @var Container
     */
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function render($response, $template, $templateVars = [])
    {
        $db = $this->getDb();

        // lista kategorija recepata je potrebna za ispis glavne navigacije
        // izvlacimo listu kategorija recepata iz baze
        $categories = $this->readCategories();
        // dodajemo 'categories' promenljivu u templejt promenljive da bi bila dostupna u templejtu
        $templateVars['categories'] = $categories;

        // za ispis sadrzaja koristimo 'view' servis iz Slim servisnog kontejnera
        $view = $this->container->get('view');
        // koristimo isti layout za sve strane
        $view->setLayout("layout/layout.php");

        return $view->render($response, $template, $templateVars);
    }

    protected function readCategories()
    {
        $db = $this->getDb();
        $query = $db->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $query->fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    protected function readCategory($categoryId)
    {
        $category = [];

        if ($categoryId > 0) {
            $db = $this->getDb();
            $statement = $db->prepare("SELECT * FROM categories WHERE id = :id");
            $statement->execute([':id' => $categoryId]);
            $category = (array)$statement->fetch(PDO::FETCH_ASSOC);
        }

        return $category;
    }

    protected function readRecipe($recipeId)
    {
        $recipe = [];

        if ($recipeId > 0) {
            $db = $this->getDb();
            $statement = $db->prepare("SELECT * FROM recipes WHERE id = :id");
            $statement->execute([':id' => $recipeId]);
            $recipe = (array)$statement->fetch(PDO::FETCH_ASSOC);
        }

        return $recipe;
    }

    protected function readRecipes($categoryId = null)
    {
        $db = $this->getDb();

        if (!empty($categoryId)) {
            $statement = $db->prepare("SELECT * FROM recipes WHERE category_id = :id ORDER BY date_updated DESC");
            $statement->execute([':id' => $categoryId]);
        } else {
            $statement = $db->prepare("SELECT * FROM recipes ORDER BY date_updated DESC");
            $statement->execute();
        }
        $recipes = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $recipes;
    }

    protected function getUploadedImage(Request $request, $recipeId = 0)
    {
        $uploadedFiles = $request->getUploadedFiles();
        $imageContent = '';

        if (!empty($uploadedFiles['image'])) {
            /** @var UploadedFile $image */
            $image = $uploadedFiles['image'];
            if (!empty($image->getClientFilename())) {
                $imageContent = $image->getStream()->getContents();
                $imageType = $image->getClientMediaType();
                $imageContent = 'data:' . $imageType . ';base64,' . base64_encode($imageContent);
            } else {
                if ($recipeId > 0) {
                    $recipe = $this->readRecipe($recipeId);
                    $imageContent = $recipe['image'];
                }
            }
        }

        return $imageContent;
    }

    protected function getFormData(Request $request)
    {
        $data = $request->getParsedBody();
        $data['name'] = isset($data['name']) ? trim($data['name']) : '';
        $data['description'] = isset($data['description']) ? trim($data['description']) : '';

        return $data;
    }

    protected function getInvalidFormFields(array $data = [])
    {
        $invalidFormFields = [];
        if (empty($data['name'])) {
            $invalidFormFields[] = 'name';
        }
        if (empty($data['description'])) {
            $invalidFormFields[] = 'description';
        }

        return $invalidFormFields;
    }

    /**
     * @return PDO
     */
    protected function getDb()
    {
        // koristimo 'db' servis iz Slim servisnog kontejnera
        $db = $this->container->get('db');
        // ovaj upit mora da se izvrsi pre svakog upita da bi se srpska slova korektno prikazivala
        $db->query("SET NAMES UTF8");

        return $db;
    }
}
