<?php

namespace App\Controllers;

use App\models\User;
use App\Validation\Validator;

class UserController extends Controller {
    public function login()
    {
        return $this->view('auth.login');
    }

    public function register()
    {
        return $this->view('auth.register');
    }

    public function loginPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'username' => ['required', 'min:3'],
            'password' => ['required']
        ]);

        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /login');
            exit(1);
        }
        if (!(new User($this->getDB()))->exist($_POST['username'])) {
            return header('Location: /login?error=true');
        }
        $user = (new User($this->getDB()))->getByUsername($_POST['username']);

        if (password_verify($_POST['password'], $user->password)) {
            $_SESSION['connectedas'] = $_POST['username'];
            $_SESSION['auth'] = ((int) $user->admin ?? 0);
            if ($_SESSION['auth'] === 1) {
                return header('Location: /admin/posts?success=true');
            }
            return header('Location: /');
        }
        return header('Location: /login?error=true');
    }

    public function registerPost()
    {
        $validator = new Validator($_POST);
        $errors = $validator->validate([
            'username' => ['required', 'min:3'],
            'password' => ['required'],
            'passwordverify' => ['required']
        ]);
        $username = $_POST['username'];
        $pass = $_POST['password'];
        if ($errors) {
            $_SESSION['errors'][] = $errors;
            header('Location: /register');
            exit(1);
        }
        
        $user = new User($this->getDB());

        if ($pass === $_POST['passwordverify']){
            $hashpwd = password_hash($pass, PASSWORD_BCRYPT);
            if ($user->register($username, $hashpwd)) {
                $_SESSION['connectedas'] = $_POST['username'];
                $_SESSION['auth'] = (int) $user->getAdminByUsername($username);
                if ($_SESSION['auth'] === 1) {
                    return header('Location: /admin/posts?success=true&registered=true');
                }
                return header('Location: /');
            }
            return header('Location: /register?error=true');
        }
        return header('Location: /register?error=true');
    }

    public function logout()
    {
        session_destroy();

        return header('Location: /');
    }
}
