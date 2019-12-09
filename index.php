<?php
require("app/app.php");
?>

<?php
$route = array(
    array('GET','/home', 'UserController2#show'),
    array('GET','/home/[i:id]', 'UserController#showDetails'),
    array('GET','/home/[i:id]/[i:id2]', 'UserController#showDetails'),
    array('GET','/signin/[i:id]', 'users#update', 'update_user'),
    array('GET','/signup/[i:id]', 'users#update', 'update_user'),
    array('GET','/account/[i:id]', 'users#update', 'update_user'),
    array('PATCH','/users/[i:id]', 'users#update', 'update_user'),
    array('DELETE','/users/[i:id]', 'users#delete', 'delete_user') 
);

$app = new App();
$app->setRoutes($route);
$app->setDB("127.0.0.1", "demo", "my_password", "demo");
//$app->do();


require_once 'app/lib/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('app/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'app/cache/compilation_cache',
    'auto_reload' => true
]);

$app->setRender($twig);
$app->do();
//$template = $twig->load('root1.html');
//echo $template->render(['statstic'=>'Ok','the' => 'variables', 'go' => 'here']);
?>