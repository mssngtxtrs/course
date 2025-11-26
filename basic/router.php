<?php
$request = $_SERVER['REQUEST_URI'];
$root = $_SERVER['DOCUMENT_ROOT'];

switch ($request) {
case '':
case '/':
    echo $constructor->constructPage([ "head.php", "header.php", "banner.html", "advantages.html", "hostings-slider.php", "footer.php" ], "Главная страница");
    break;
case '/about':
    echo $constructor->constructPage([ "head.php", "header.php", "footer.php" ], "О нас");
    break;
case '/hostings':
    echo $constructor->constructPage([ "head.php", "header.php", "footer.php" ], "Хостинги");
    break;
case '/account':
    if (empty($user['name'])) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage([ "head.php", "header.php", "footer.php" ], "Личный кабинет");
    }
    break;
case '/auth':
    if (!empty($user['name'])) {
        header("Location: account");
    } else {
        echo $constructor->constructPage([ "head.php", "header.php", "auth.html", "footer.php" ], "Авторизация");
    }
    break;
case '/auth#login':
    $auth->login($_POST['login'], $_POST['password']);
    header("Location: account");
    break;
case '/auth#reg':
    $auth->register([$_POST['email'], $_POST['login'], $_POST['name'], $_POST['surname']], $_POST['password'], $_POST['password_confirm'], $_POST['consent']);
    header("Location: account");
    break;
default:
    http_response_code(404);
    echo $constructor->constructPage([ "head.php", "header.php", "rickroll.html", "404.html", "footer.php" ], "Страница не найдена");
    break;
}
?>
