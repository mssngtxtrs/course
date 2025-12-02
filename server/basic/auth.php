<?php
namespace Server;

class Auth {
    private bool $is_logged_in = false;
    private array $credentials = [
        'name' => "",
        'login' => "",
        'email' => ""
    ];




    public function __construct(bool $try_auto_login) {
        if ($try_auto_login) {
            $this->autoLogin();
        }
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
        return $database->returnQuery(
            "select `userID` from `users` where `login` = ?",
            "single",
            [ $login ]
        );
    }



    public function getPermissionLevel(): int {
        global $database;
        return $database->returnQuery(
            "select `permissionLevel` from `users` where `login` = ",
            "single",
            [ $this->credentials['login'] ]
        );
    }



    public function getName(): string {
        return $this->credentials['name'];
    }



    public function getLogInStatus(): bool {
        return $this->is_logged_in;
    }



    public function autoLogin(): bool {
        $output = false;

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
                    if ($this->credentials = $database->returnQuery(
                        "select `name`, `login`, `email` from `users` where `login` = ?",
                        "assoc",
                        [ $_SESSION['user']['login'] ]
                    )[0]) {
                        $this->is_logged_in = true;
                        $_SESSION['msg']['dbg'][] = "auto-success";
                        $output = true;
                    } else {
                        $_SESSION['msg']['dbg'][] = "auto-failed-uncaught-sql";
                    }
                } else {
                    $_SESSION['msg']['dbg'][] = "auto-failed-incorrect-password";
                }
            } else {
                $_SESSION['msg']['dbg'][] = "auto-failed-no-user";
            }
        } else {
            $_SESSION['msg']['dbg'][] = "auto-failed-no-credentials";
        }
        return $output;
    }



    public function login(string $login, string $password): bool {
        global $database;
        $userID = $database->returnQuery("select `userID` from `users` where `login` = ?", "single", [$login]);

        $output = false;

        if (!empty($password) && !empty($login)) {
            if ($userID) {
                if ($this->verifyPassword($password, $userID, true)) {
                    $_SESSION['user']['login'] = $login;
                    $_SESSION['user']['hash'] = $database->returnQuery("select `password` from `passwords` where `userID` = '$userID'", "single");

                    if ($this->credentials = $database->returnQuery(
                        "select `name`, `login`, `email` from `users` where `login` = ?",
                        "assoc",
                        [ $_SESSION['user']['login'] ]
                    )) {
                        $_SESSION['msg']['std'][] = "login-success";
                        $output = true;
                    } else {
                        $_SESSION['msg']['error'][] = "login-failed-uncaught-sql";
                    }
                } else {
                    $_SESSION['msg']['error'][] = "login-failed-incorrect-password";
                }
            } else {
                $_SESSION['msg']['error'][] = "login-failed-no-user";
            }
        } else {
            $_SESSION['msg']['error'][] = "login-failed-no-credentials";
        }
        return $output;
    }



    public function logout() {
        unset($_SESSION['user']);
        /* session_unset(); */
        /* session_destroy(); */
        $_SESSION['msg']['std'][] = "logout";
    }



    public function register(array $credentials, string $password, string $password_confirm, string $consent): bool {
        global $database;

        $output = false;

        if (empty($credentials) || empty($password) || empty($password_confirm) || empty($consent)) {
            $_SESSION['msg']['error'][] = "reg-failed-empty-fields";
        } else {
            if ($database->returnQuery(
                "select * from `users` where `login` = ?",
                "bool",
                [ $credentials['login'] ]
            )) {
                $_SESSION['msg']['error'][] = "reg-failed-user-exists";
            } else {
                if (!$consent) {
                    $_SESSION['msg']['error'][] = "reg-failed-no-consent";
                } else {
                    if ($password !== $password_confirm) {
                        $_SESSION['msg']['error'][] = "reg-failed-not-match";
                    } else {
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);

                        if (!$database->returnQuery(
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
                            $_SESSION['msg']['error'][] = "reg-failed-uncaught-sql";
                        } else {
                            $_SESSION['msg']['std'][] = "reg-success";
                            $output = true;
                        }
                    }
                }
            }
        }
        return $output;
    }
}
?>
