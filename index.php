<?php
// Include Composer's autoload file
require 'vendor/autoload.php';

//After every Update in the Composer.json should run composer dump-autoload

// Use the Router class
use Project\Cms\Router;
//use App\Controllers\UserController;
//Instantiate the Router
$router = new Router();

// Define your routes for controller
$router->add('user', 'AdminController@create_admin');
$router->add('blog', 'AdminController@blog');
// $router->add('hello_world', 'AdminController@hello_world');
$router->add('adduser', 'AdminController@create_user');
$router->add('muser','AdminController@manage_users');
$router->add('fuser','AdminController@fetch_user');
$router->add('uuser','AdminController@update_user');
$router->add('duser','AdminController@delete_user');
$router->add('mcat','AdminController@manage_cat');
$router->add('uart','AdminController@create_article');
$router->add('upro','AdminController@user_profile');
$router->add('mart','AdminController@manage_article');
$router->add('bview','AdminController@blog_view');
$router->add('bread','AdminController@read_post');

// Define routes for autoloaded classes
$router->add('example', 'ExampleClass@greet');
$router->add('example1', 'ExampleClass1@add');
$router->add('example2', 'ExampleClass2@sub');
$router->add('example3', 'ExampleClass3@mul');

// Define routes for login and logout
$router->add('login', 'AdminController@login');
$router->add('welcome', 'AdminController@welcome');
$router->add('logout', 'AdminController@logout');

// Get the URL from the query string, default to empty
$url = isset($_GET['url']) ? $_GET['url'] : '';

// Route the request
$router->dispatch($url);
