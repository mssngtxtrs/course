<?php
namespace Server;

$_SESSION['user'] = [
    'name' => "Тут должен быть логин",
    'password' => "123"
];

/* $user = [ */
/*     "name" => "Тут должно быть имя", */
/*     "id" => 0 */
/* ]; */

class Auth {
    private $login;
    private $credentials;

    public function __construct() {
        throw new \Exception('Not implemented');
        $session = $_SESSION['user'];
    }

    public function __unset($name) {
        unset($login);
        unset($credentials);
    }

    private function verifyPassword() {
        throw new \Exception('Not implemented');
    }

    private function getCredentials() {
        throw new \Exception('Not implemented');
    }

    public function register($login, $password, $password_confirm, $consent) {
        global $database;

        if ($database->returnQuery("select `login` from `users`") === null) {
            return "failed-user-exists";
        } else {
            if (!$consent) {
                return "failed-no-consent";
            } else {
                if ($password !== $password_confirm) {
                    return "failed-not-match";
                } else {

                }
            }
        }
    }
}
?>
