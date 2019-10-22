<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Slim\Views\PhpRenderer;
use \Cookbook\Action\HomeAction;
use \Cookbook\Action\ListAction;
use \Cookbook\Action\RecipeFormAction;
use \Cookbook\Action\CreateRecipeAction;
use \Cookbook\Action\ReadRecipeAction;
use \Cookbook\Action\UpdateRecipeAction;
use \Cookbook\Action\DeleteRecipeAction;

require '../../vendor/autoload.php';

/**
 * konfiguracija aplikacije
 */

// konfiguracija Slim frameworka - prikazati sve informacije o greskama koje se dese
$config['displayErrorDetails'] = true;

// konfiguracija pristupa bazi podataka
$config['db']['host']   = 'localhost';
$config['db']['user']   = 'root';
$config['db']['pass']   = 'root';
$config['db']['dbname'] = 'cookbook';

/**
 * instanciranje aplikacije
 */
$app = new \Slim\App(['settings' => $config]);

/**
 * servisni kontejner Slim frameworka i definisanje servisa
 */

$container = $app->getContainer();

// servis za konekciju na bazu podataka
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
    return $pdo;
};

// servis za ispisivanje sadrzaja (view), konfigurisan da koristi templejte iz templates direktorijuma
$container['view'] = new PhpRenderer('../../templates/');

/**
 * definisanje ruta za Slim framework
 */

// naslovna strana: prikazuje jedan slucajno odabrani recept i listu najnovijih recepata
$app->get('/', HomeAction::class);

// prikaz recepata iz odredjene kategorije
$app->get('/recipe/list/{category-id}', ListAction::class);

// prikaz forme za unos ili izmenu recepta
$app->get('/recipe/form[/{recipe-id}]', RecipeFormAction::class);

// REST ruta za kreiranje novog recepta (C iz CRUD)
$app->post('/recipe/create', CreateRecipeAction::class);

// REST ruta za citanje / prikaz recepta (R iz CRUD)
$app->get('/recipe/read/{recipe-id}', ReadRecipeAction::class);

// REST ruta za izmenu postojeceg recepta (U iz CRUD)
$app->post('/recipe/update', UpdateRecipeAction::class);

// REST ruta za brisanje recepta (D iz CRUD)
$app->get('/recipe/delete/{recipe-id}', DeleteRecipeAction::class);

/**
 * definisanje middleware-a za Slim framework
 */

$app->run();
