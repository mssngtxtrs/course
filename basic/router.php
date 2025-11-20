<?php
$request = $_SERVER['REQUEST_URI'];
$root = $_SERVER['DOCUMENT_ROOT'];

switch ($request) {
case '':
case '/':
    require $root . '/templates/main.php';
    break;
case '/about':
    require $root . '/templates/about.php';
    break;
case '/hostings':
    require $root . '/templates/hostings.php';
    break;
case '/account':
    require $root . '/templates/account.php';
    break;
default:
    http_response_code(404);
    require $root . '/templates/404.php';
    break;
}
?>
