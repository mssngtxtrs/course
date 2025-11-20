<?php
$request = $_SERVER['REQUEST_URI'];
$root = $_SERVER['DOCUMENT_ROOT'];

switch ($request) {
case '':
case '/':
    require $root . '/templates/main_construct.php';
    break;
case '/about':
    require $root . '/templates/about_construct.php';
    break;
case '/hostings':
    require $root . '/templates/hostings_construct.php';
    break;
case '/account':
    require $root . '/templates/account_construct.php';
    break;
default:
    http_response_code(404);
    require $root . '/templates/404_construct.php';
    break;
}
?>
