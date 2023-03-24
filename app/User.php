<?php

include 'Database.php';

class User
{

    private object $con;

    public function __construct()
    {
        $this -> con = new Database;
    }

    public function register(array $registerInfo): string
    {
        if (isset($registerInfo['username'], $registerInfo['email'], $registerInfo['password'], $registerInfo['confirm'])) {
            if (!(empty($registerInfo['username']) || empty($registerInfo['email']) || empty($registerInfo['password']) || empty($registerInfo['confirm']))) {
                if (filter_var($registerInfo['email'], FILTER_VALIDATE_EMAIL)) {
                    if (preg_match('/^[a-zA-Z0-9]+$/', $registerInfo['username']) === 1) {
                        if (strlen($registerInfo['username']) > 3 && strlen($registerInfo['username']) < 16) {
                            $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                            if ($result -> num_rows === 0) {
                                $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE email = ?', [$registerInfo['email']]);
                                if ($result -> num_rows === 0) {
                                    $password = password_hash($registerInfo['password'], PASSWORD_DEFAULT);
                                    $this -> con -> db -> execute_query('INSERT INTO `user` (`username`, `password`, `email`) VALUES (?, ?, ?)', [
                                        $registerInfo['username'],
                                        $password,
                                        $registerInfo['email'],
                                    ]);
                                    $result = $this -> con -> db -> execute_query('SELECT user_id FROM user WHERE username = ?', [$registerInfo['username']]);
                                    $user_id = $result -> fetch_column();
                                    setcookie('username', $registerInfo['username'], strtotime('NOW+60DAYS'));
                                    setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                    setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                    return 'Ok';
                                } else {
                                    return 'Sorry, that email is already taken';
                                }
                            } else {
                                return 'Sorry, that username is already taken.';
                            }
                        } else {
                            return 'The username  must be between 3 and 16 characters long.';
                        }
                    } else {
                        return 'The username must only contain alphanumeric characters.';
                    }
                } else {
                    return 'That email format is not valid.';
                }
            } else {
                return 'Please fill up the missing fields.';
            }
        } else {
            return 'Please fill up the missing fields.';
        }
    }

    public function login(array $loginInfo): string
    {
        if (isset($loginInfo['username'], $loginInfo['password'])) {
            if (!(empty($loginInfo['username']) || empty($loginInfo['password']))) {
                if (preg_match('/^[a-zA-Z0-9]+$/', $loginInfo['username']) === 1) {
                    if (strlen($loginInfo['username']) > 3 && strlen($loginInfo['username']) < 16) {
                        // Comprobación del nombre de usuario. Si coincide se comprobará la contraseña.
                        $result = $this -> con -> db -> execute_query('SELECT `user_id` FROM user WHERE username = ?', [$loginInfo['username']]);
                        if ($result -> num_rows === 1) {
                            $user_id = $result -> fetch_column();
                            // Comprobación de la contraseña. Si coincide se autenticará al usuario.
                            $result = $this -> con -> db -> execute_query('SELECT `password` FROM user WHERE username = ?', [$loginInfo['username']]);
                            $password = $result -> fetch_column();
                            if (password_verify($loginInfo['password'], $password)) {
                                // Todas las verificaciones han sido exitosas, por lo que se inicia una sesión al usuario autenticado.
                                setcookie('username', $loginInfo['username'], strtotime('NOW+60DAYS'));
                                setcookie('user_id', $user_id, strtotime('NOW+60DAYS'));
                                setcookie('session', "Yes", strtotime('NOW+60DAYS'));
                                return 'Ok';
                            } else {
                                return 'Incorrect username or password';
                            }
                        } else {
                            return 'Incorrect username or password.';
                        }
                    } else {
                        return 'Incorrect username or password.';
                    }
                } else {
                    return 'Incorrect username or password.';
                }
            } else {
                return 'Please fill up the missing fields.';
            }
        } else {
            return 'Please fill up the missing fields.';
        }
    }

    public function getInfo(string $username): array
    {
        $result = $this -> con -> db -> execute_query('SELECT * FROM user WHERE user_id = ?', [$_COOKIE['user_id']]);
        $userInfo = $result -> fetch_assoc();

        return $userInfo;
    }
}