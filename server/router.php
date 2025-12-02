<?php
$request = $_SERVER['REQUEST_URI'];
$path = parse_url($request, PHP_URL_PATH);
$query = $_GET;

/* echo "<pre>"; */
/* var_dump($request); */
/* var_dump($path); */
/* var_dump($query); */
/* echo "</pre>"; */

switch (true) {



case $path == '':
case $path == '/':
    echo $constructor->constructPage(
        [ "head", "header", "banner", "advantages", "hostings-slider", "banner-2", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/about':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/hostings':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/account':
    if (!$auth->getLogInStatus()) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "footer" ],
            $dictionary->getDictionaryString($request, "paths"),
            $global_flags['show-messages']
        );
        $_SESSION['page_back'] = $request;
    }
    break;



case $path == '/reservation':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/auth':
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
            $_SESSION['page_back'] = $request;
        }
        break;
    }
    break;



case $path == '/loc':
    $constructor->setSessionLocale($query['lang'] ?? '');
    header("Location: {$_SESSION['page_back']}");
    break;



case preg_match('#^/api/.*$#', $path):
    switch ($path) {
    case "/api/hostings":
        switch ($query['method'] ?? "") {
        case "slider":
            header("Content-Type: text/html");
            echo $hostings->returnData("slider");
            break;
        case "serialized":
            header("Content-Type: text/plain");
            echo $hostings->returnData("serialized");
            break;
        case "json":
        default:
            header("Content-Type: application/json");
            echo json_encode([
                'status' => 'ok',
                'content' => $hostings->returnData()
            ]);
            break;
        }
        break;
    case "/api/messages":
        header("Content-Type: application/json");
        echo json_encode([
            'status' => 'ok',
            'content' => $message_handler->returnMessages($global_flags['debug'])
        ]);
        break;
    }
    break;



case $path == '/what':
    echo $constructor->constructPage(
        [ "head", "header", "rickroll", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



default:
    http_response_code(404);
    echo $constructor->constructPage(
        [ "head", "header", "404", "footer" ],
        $dictionary->getDictionaryString('404', "paths"),
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;
}



?>
