<?php
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$query = $_GET;

switch ($path) {



case '':
case '/':
    echo $constructor->constructPage(
        [ "head", "header", "banner", "advantages", "hostings-slider", "banner-2", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    break;



case '/about':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    break;



case '/hostings':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    break;



case '/account':
    if (!$auth->getLogInStatus()) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "footer" ],
            $dictionary->getDictionaryString($request, "paths"),
            $global_flags['show-messages']
        );
    }
    break;



case '/auth':
    switch ($query['action'] ?? '') {
    case "log-in":
        $auth->login(
            $database->escape($_POST['login']) ?? "",
            $database->escape($_POST['password']) ?? ""
        );
        header("Location: {$_SESSION['page_back']}");
        break;

    case "register":
        $auth->register(
            [
                'email' => $database->escape($_POST['email']) ?? "",
                'login' => $database->escape($_POST['login']) ?? "",
                'name' => $database->escape($_POST['name']) ?? "",
                'surname' => $database->escape($_POST['surname']) ?? ""
            ],
            $database->escape($_POST['password']) ?? "",
            $database->escape($_POST['password-confirm']) ?? "",
            $database->escape($_POST['consent']) ?? ""
        );
        header("Location: {$_SESSION['page_back']}");
        break;

    case "log-out":
        $auth->logout();
        header("Location: {$_SESSION['page_back']}");
        break;

    case '':
    default:
        if ($auth->getLogInStatus()) {
            header("Location: account");
        } else {
            echo $constructor->constructPage(
                [ "head", "header", "auth", "footer" ],
                $dictionary->getDictionaryString($request, "paths"),
                $global_flags['show-messages']
            );
        }
        break;
    }
    break;



case '/loc':
    $constructor->setSessionLocale($query['lang'] ?? '');
    header("Location: {$_SESSION['page_back']}");
    break;



case '/what':
    echo $constructor->constructPage(
        [ "head", "header", "rickroll", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    break;



default:
    http_response_code(404);
    echo $constructor->constructPage(
        [ "head", "header", "404", "footer" ],
        $dictionary->getDictionaryString('404', "paths"),
        $global_flags['show-messages']
    );
    break;
}



$_SESSION['page_back'] = $request;
?>
