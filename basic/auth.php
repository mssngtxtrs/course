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
            return password_verify(
                $password,
                $database->returnQuery("select `password` from `passwords` where `userID` = '$userID'", "single")
            );
        } else {
            return $database->returnQuery("select `password` from `passwords` where `userID` = '$userID'", "single") === $password;
        }
    }



    private function getUserID(string $login): int {
        global $database;
        return $database->returnQuery("select `userID` from `users` where `login` = '$login'", "single");
    }



    public function getName(): string {
        return $this->name;
    }



    public function autoLogin() {
        if (isset($_SESSION['user']['login']) && isset($_SESSION['user']['hash'])) {
            global $database;
            if ($database->returnQuery(
                'select * from `users` where `login` = ?',
                "bool",
                [ $_SESSION['user']['login'] ]
            )) {
                if ($this->verifyPassword(
                    $_SESSION['user']['hash'],
                    $this->getUserID($_SESSION['user']['login'])
                )) {
                    $this->name = $database->returnQuery(
                        "select `name` from `users` where `login` = ?",
                        "single",
                        [ $_SESSION['user']['login'] ]
                    );
                    $this->credentials = $database->returnQuery(
                        "select `login`, `email` from `users` where `login` = ?",
                        "assoc",
                        [ $_SESSION['user']['login'] ]
                    );
                    $_SESSION['msg']['dbg'][] = "auto-success";
                } else {
                    $this->name = "";
                    $this->credentials = [ 'login' => "", 'email' => "" ];
                    $_SESSION['msg']['dbg'][] = "auto-failed-incorrect-password";
                }
            } else {
                $this->name = "";
                $this->credentials = [ 'login' => "", 'email' => "" ];
                $_SESSION['msg']['dbg'][] = "auto-failed-no-user";
            }
        } else {
            $this->name = "";
            $this->credentials = [ 'login' => "", 'email' => "" ];
            $_SESSION['msg']['dbg'][] = "auto-failed-no-credentials";
        }
    }


    public function login(string $login, string $password): bool {
        global $database;
        $userID = $database->returnQuery("select `userID` from `users` where `login` = ?", "single", [$login]);

        if ($userID) {
            if ($this->verifyPassword($password, $userID, true)) {
                $_SESSION['user']['login'] = $login;
                $_SESSION['user']['hash'] = $database->returnQuery("select `password` from `passwords` where `userID` = '$userID'", "single");

                $this->name = $database->returnQuery(
                    "select `name` from `users` where `login` = ?",
                    "single",
                    [$_SESSION['user']['login']]
                );
                $this->credentials = $database->returnQuery(
                    "select `login`, `email` from `users` where `login` = ?",
                    "assoc",
                    [ $_SESSION['user']['login'] ]
                );

                $_SESSION['msg']['std'][] = "login-success";
                return true;
            } else {
                $_SESSION['msg']['error'][] = "login-failed-incorrect-password";
                return false;
            }
        } else {
            $_SESSION['msg']['error'][] = "login-failed-no-user";
            return false;
        }
    }



    public function register(array $credentials, string $password, string $password_confirm, string $consent): bool {
        global $database;

        if ($database->returnQuery(
            "select * from `users` where `login` = ?",
            "bool",
            [ $credentials['login'] ]
        )) {
            $_SESSION['msg']['error'][] = "reg-failed-user-exists";
            return false;
        } else {
            if (!$consent) {
                $_SESSION['msg']['error'][] = "reg-failed-no-consent";
                return false;
            } else {
                if ($password !== $password_confirm) {
                    $_SESSION['msg']['error'][] = "reg-failed-not-match";
                    return false;
                } else {
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);

                    if ($database->returnQuery(
                        "insert into `users` (`email`, `login`, `name`, `surname`, `permissionLevel`) values (?, ?, ?, ?, 0)",
                        "bool",
                        [
                            $credentials['email'],
                            $credentials['login'],
                            $credentials['name'],
                            $credentials['surname']
                        ]
                    ) && $database->returnQuery(
                        "insert into `passwords` (`userID`, `password`) values (?, ?)",
                        "bool",
                        [
                            $this->getUserID($credentials['login']),
                            $password_hash
                        ]
                    )) {
                        $_SESSION['msg']['std'][] = "reg-success";
                        return true;
                    } else {
                        $_SESSION['msg']['error'][] = "reg-failed-uncaught-sql";
                        return false;
                    }
                }
            }
        }
    }
}
?>
