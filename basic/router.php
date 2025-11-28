<?php
$request = $_SERVER['REQUEST_URI'];

switch (true) {
case $request == '':
case $request == '/':
    echo $constructor->constructPage(
        [ "head", "header", "banner", "advantages", "hostings-slider", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        true
    );
    $_SESSION['page_back'] = $request;
    break;

case $request == '/about':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        true
    );
    $_SESSION['page_back'] = $request;
    break;

case $request == '/hostings':
    echo $constructor->constructPage(
        [ "head", "header", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        true
    );
    $_SESSION['page_back'] = $request;
    break;

case $request == '/account':
    if (!$auth->getLogInStatus()) {
        header("Location: auth");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "footer" ],
            $dictionary->getDictionaryString($request, "paths"),
            true
        );
        $_SESSION['page_back'] = $request;
    }
    break;

case $request == '/auth':
    if ($auth->getLogInStatus()) {
        header("Location: account");
    } else {
        echo $constructor->constructPage(
            [ "head", "header", "auth", "footer" ],
            $dictionary->getDictionaryString($request, "paths"),
            true
        );
        $_SESSION['page_back'] = $request;
    }
    break;



case $request == '/login':
    /* echo "<pre>"; */
    /* var_dump($_SESSION); */
    /* unset($_SESSION['msg']); */
    /* unset($_SESSION['error']); */
    /* unset($_SESSION['dbg']); */

    $auth->login(
        $database->escape($_POST['login']) ?? "",
        $database->escape($_POST['password']) ?? ""
    );

    header("Location: account");
    break;



case $request == "/logout":
    $auth->logout();
    header("Location: {$_SESSION['page_back']}");
    break;



case $request == '/reg':
    /* echo "<pre>"; */
    /* var_dump($_SESSION); */
    /* unset($_SESSION['msg']); */
    /* unset($_SESSION['error']); */
    /* unset($_SESSION['dbg']); */

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



case preg_match('#^/loc\?#', $request):
    $constructor->setSessionLocale($_GET['lang']);
    header("Location: {$_SESSION['page_back']}");
    break;



case $request == "/what":
    echo $constructor->constructPage(
        [ "head", "header", "rickroll", "footer" ],
        $dictionary->getDictionaryString($request, "paths"),
        true
    );
    $_SESSION['page_back'] = $request;
    break;

default:
    http_response_code(404);
    echo $constructor->constructPage(
        [ "head", "header", "404", "footer" ],
        $dictionary->getDictionaryString('404', "paths"),
        true
    );
    $_SESSION['page_back'] = $request;
    break;
}
?>
