<?php
namespace Server;

class Auth {
    private string $name;
    private array $credentials;



    public function __construct() {
        $this->autoLogin();
    }



    public function __unset($name) {
        unset($login);
        unset($credentials);
    }



    private function verifyPassword(string $password, int $userID, bool $raw_password = false): bool {
        global $database;

        if ($raw_password) {
            $password = password_hash($password, PASSWORD_DEFAULT);
        }

        return password_verify(
            $password,
            $database->returnQuery("select `password` from `passwords` where `userID` = '$userID'", "single")
        );
    }



    private function getUserID(string $login): int {
        global $database;
        return $database->returnQuery("select `userID` from `users` where `login` = '$login'", "single");
    }



    public function getName(): string {
        return $this->name;
    }



    public function autoLogin() {
        if (isset($_SESSION['login']) && isset($_SESSION['hash'])) {
            if ($this->verifyPassword(
                $_SESSION['hash'],
                $this->getUserID($_SESSION['login'])
            )) {
                global $database;
                $this->name = $database->returnQuery("select `name` from `users` where `login` = '{$_SESSION['login']}'", "single");
                $this->credentials = $database->returnQuery("select `login`, `email` from `users` where `login` = '{$_SESSION['login']}'");
            } else {
                $this->name = "";
                $this->credentials = [ 'login' => "", 'email' => "" ];
            }
        } else {
            $this->name = "";
            $this->credentials = [ 'login' => "", 'email' => "" ];
        }
    }


    public function login(string $login, string $password): bool {
        global $database;
        $userID = $database->returnQuery("select `userID` from `users` where `login` = '$login'", "single");

        if ($userID) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            if ($this->verifyPassword($password, $userID)) {
                $_SESSION['user']['login'] = $login;
                $_SESSION['user']['password'] = $password_hash;

                $this->name = $database->returnQuery("select `name` from `users` where `login` = '{$_SESSION['login']}'", "single");
                $this->credentials = $database->returnQuery("select `login`, `email` from `users` where `login` = '{$_SESSION['login']}'");

                $_SESSION['msg'] = "login-success";
                return true;
            } else {
                $_SESSION['error'] = "login-failed-incorrect-password";
                return false;
            }
        } else {
            $_SESSION['error'] = "login-failed-no-user";
            return false;
        }
    }



    public function register(array $credentials, string $password, string $password_confirm, string $consent): bool {
        global $database;

        if ($database->returnQuery("select `login` from `users` where `login` = '{$credentials['login']}'") === null) {
            $_SESSION['error'] = "reg-failed-user-exists";
            return false;
        } else {
            if (!$consent) {
                $_SESSION['error'] = "reg-failed-no-consent";
                return false;
            } else {
                if ($password !== $password_confirm) {
                    $_SESSION['error'] = "reg-failed-not-match";
                    return false;
                } else {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    if ($database->prepareAndExecute(
                        "insert into `users` (`email`, `login`, `name`, `surname`, `permissionLevel`) values (?, ?, ?, ?, 0)",
                        $credentials
                    ) && $database->prepareAndExecute(
                        "insert into `passwords` (`password`) values (?)",
                        [$password_hash]
                    )) {
                        $_SESSION['msg'] = "reg-success";
                        return true;
                    } else {
                        $_SESSION['error'] = "reg-failed-uncaught-sql";
                        return false;
                    }
                }
            }
        }
    }
}
?>
