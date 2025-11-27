<?php
$request = $_SERVER['REQUEST_URI'];
$root = $_SERVER['DOCUMENT_ROOT'];

switch ($request) {
case '':
case '/':
    echo $constructor->constructPage(
        [ "head.php", "header.php", "banner.html", "advantages.html", "hostings-slider.php", "footer.php" ],
        "Главная страница",
        true
    );
    break;
case '/about':
    echo $constructor->constructPage(
        [ "head.php", "header.php", "footer.php" ],
        "О нас",
        true
    );
    break;
case '/hostings':
    echo $constructor->constructPage(
        [ "head.php", "header.php", "footer.php" ],
        "Хостинги",
        true
    );
    break;
case '/account':
    if (empty($_SESSION['user']['login'])) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage(
            [ "head.php", "header.php", "footer.php" ],
            "Личный кабинет",
            true
        );
    }
    break;
case '/login':
    /* echo "<pre>"; */
    /* var_dump($_SESSION); */
    /* unset($_SESSION['msg']); */
    /* unset($_SESSION['error']); */
    /* unset($_SESSION['dbg']); */

    $auth->login(
        $_POST['login'],
        $_POST['password']
    );

    header("Location: account");
    break;
case "/logout":
    unset($_SESSION['user']);
    header("Location:./");
    break;
case '/reg':
    /* echo "<pre>"; */
    /* var_dump($_SESSION); */
    /* unset($_SESSION['msg']); */
    /* unset($_SESSION['error']); */
    /* unset($_SESSION['dbg']); */

    $auth->register(
        [
            'email' => $_POST['email'],
            'login' => $_POST['login'],
            'name' => $_POST['name'],
            'surname' => $_POST['surname']
        ],
        $_POST['password'],
        $_POST['password-confirm'],
        $_POST['consent']
    );

    header("Location: account");
    break;
case '/auth':
    if (!empty($_SESSION['user']['login'])) {
        header("Location: account");
    } else {
        echo $constructor->constructPage(
            [ "head.php", "header.php", "auth.html", "footer.php" ],
            "Авторизация",
            true
        );
    }
    break;
case "/what":
    echo $constructor->constructPage(
        [ "head.php", "header.php", "rickroll.html", "footer.php" ],
        "Страница не найдена",
        true
    );
    break;
default:
    http_response_code(404);
    echo $constructor->constructPage(
        [ "head.php", "header.php", "404.html", "footer.php" ],
        "Страница не найдена",
        true
    );
    break;
}
?>
