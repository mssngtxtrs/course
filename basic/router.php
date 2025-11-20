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
    if (empty($user['name'])) {
        header("Location: login");
    } else {
        require $root . '/templates/account.php';
    }
    break;
/* case '/login': */
/*     if (!empty($user['name'])) { */
/*         header("Location: account"); */
/*     } else { */
/*         require $root . '/templates/login.php'; */
/*     } */
/*     break; */
case '/auth':
    if (!empty($user['name'])) {
        header("Location: account");
    } else {
        require $root . '/templates/auth.php';
    }
    break;
default:
    http_response_code(404);
    require $root . '/templates/404.php';
    break;
}
?>
