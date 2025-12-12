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
        "Главная",
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/about':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        "О нас",
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



case $path == '/hostings':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        "Хостинги",
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
            "Личный кабинет",
            $global_flags['show-messages']
        );
        $_SESSION['page_back'] = $request;
    }
    break;



case $path == '/reservation':
    if (!$auth->getLogInStatus()) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "footer" ],
            "Новая заявка",
            $global_flags['show-messages']
        );
        $_SESSION['page_back'] = $request;
    }
    break;



case $path == '/auth':
    if ($auth->getLogInStatus()) {
        header("Location: account");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "auth", "footer" ],
            "Авторизация",
            $global_flags['show-messages']
        );
        $_SESSION['page_back'] = $request;
    }
    break;



case preg_match('#^/api/.*$#', $path):
    require "server/custom/hostings.php";
    $output = [
        'status' => "failed",
        'action' => null,
        'output' => null
    ];

    switch ($path) {
    case "/api/hostings":
        switch ($query['method'] ?? "") {
        case "slider":
            header("Content-Type: text/html");
            echo Server\Custom\Hostings::returnHostings("slider");
            break;
        case "json":
        default:
            header("Content-Type: application/json");
            $output['action'] = 'hostings-info';
            $output['output'] = Server\Custom\Hostings::returnHostings("raw");
            $output['status'] = 'ok';
            echo json_encode($output);
            break;
        }
        break;


    case "/api/hostings/cpu":
        header("Content-Type: application/json");
        $output['action'] = 'cpu-info';
        $output['output'] = Server\Custom\Hostings::returnCPU();
        $output['status'] = 'ok';
        echo json_encode($output);
        break;


    case "/api/messages":
        header("Content-Type: application/json");
        $output['action'] = 'return-messages';
        $output['output'] = $message_handler->returnMessages($global_flags['debug']);
        $output['status'] = 'ok';
        echo json_encode($output);
        break;


    case "/api/auth/log-out":
        $output['action'] = "log-out";
        $output['output'] = $auth->logout();
        $output['status'] = "ok";
        /* echo json_encode($output); */
        header("Location: {$_SESSION['page_back']}");
        break;


    case "/api/auth/log-in":
        $output['action'] = "log-in";
        $output['output'] = $auth->login(
            $database->escape($_POST['login']),
            $database->escape($_POST['password'])
        );
        $output['status'] = "ok";
        /* echo json_encode($output); */
        header("Location: {$_SESSION['page_back']}");
        break;


    case "/api/auth/register":
        $output['action'] = "register";
        $output['output'] = $auth->register(
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
        $output['status'] = "ok";
        /* echo json_encode($output); */
        header("Location: {$_SESSION['page_back']}");
        break;


    case "/api/auth/get-name":
        header("Content-Type: application/json");
        $output['action'] = "get-name";
        $output['output'] = $auth->getName();
        $output['status'] = "ok";
        echo json_encode($output);
        break;


    case "/api/auth/get-log-in-status":
        header("Content-Type: application/json");
        $output['action'] = "get-log-in-status";
        $output['output'] = $auth->getLogInStatus();
        $output['status'] = "ok";
        echo json_encode($output);
        break;

    default:
        header("Location:/404");
        break;
    }
    break;



case $path == '/what':
    echo $constructor->constructPage(
        [ "head", "header", "rickroll", "footer" ],
        "Вам бы лучше и не знать...",
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;



default:
    http_response_code(404);
    echo $constructor->constructPage(
        [ "head", "header", "404", "footer" ],
        "Страница не найдена",
        $global_flags['show-messages']
    );
    $_SESSION['page_back'] = $request;
    break;
}



?>
