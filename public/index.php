<?php

use Router\Router;
use App\Exceptions\NotFoundException;


require_once '../vendor/autoload.php';

define('ROOT',  dirname(__DIR__));
define('HREF_ROOT', '/' );
// Not in use now. J'ai utilisé cette constante pour trouvé des bugs dans le les formulaire. Est peut remplacer HREF_ROOT
define('VIEWS_FORM_ROOT', '../../../' );

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);
//define('SCRIPTS', 'public/');
define('DB_NAME', 'blog_oop');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');

$router = new Router($_GET['url']);

$router->get('/', 'App\Controllers\BlogController@welcome');
$router->get('/posts', 'App\Controllers\BlogController@index');
$router->get('/posts/:id', 'App\Controllers\BlogController@show');
$router->get('/tags/:id', 'App\Controllers\BlogController@tag');

$router->get('/login', 'App\Controllers\UserController@login');
$router->post('/login', 'App\Controllers\UserController@loginPost');
$router->get('/register', 'App\Controllers\UserController@register');
$router->post('/register', 'App\Controllers\UserController@registerPost');
$router->get('/logout', 'App\Controllers\UserController@logout');

// POST
$router->get('/admin/posts', 'App\Controllers\Admin\PostController@index');
$router->get('/admin/posts/create', 'App\Controllers\Admin\PostController@create');
$router->post('/admin/posts/create', 'App\Controllers\Admin\PostController@createPost');
$router->get('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@edit');
$router->post('/admin/posts/edit/:id', 'App\Controllers\Admin\PostController@update');
$router->post('/admin/posts/delete/:id', 'App\Controllers\Admin\PostController@destroy');
// TAG
$router->get('/admin/tags', 'App\Controllers\Admin\TagController@index');
$router->get('/admin/tags/create', 'App\Controllers\Admin\TagController@create');
$router->post('/admin/tags/create', 'App\Controllers\Admin\TagController@createTag');
$router->get('/admin/tags/edit/:id', 'App\Controllers\Admin\TagController@edit');
$router->post('/admin/tags/edit/:id', 'App\Controllers\Admin\TagController@update');
$router->post('/admin/tags/delete/:id', 'App\Controllers\Admin\TagController@destroy');
// IMAGE
$router->get('/admin/images', 'App\Controllers\Admin\ImageController@index');
$router->get('/admin/images/create', 'App\Controllers\Admin\ImageController@create');
$router->post('/admin/images/create', 'App\Controllers\Admin\ImageController@createImage');
$router->get('/admin/images/edit/:id', 'App\Controllers\Admin\ImageController@edit');
$router->post('/admin/images/edit/:id', 'App\Controllers\Admin\ImageController@update');
$router->delete('/admin/images/delete/:id', 'App\Controllers\Admin\ImageController@destroy');

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}