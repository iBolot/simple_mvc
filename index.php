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
$app->do();

;
?>
