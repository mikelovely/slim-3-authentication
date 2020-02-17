<?php

namespace App\Auth;

use App\User\User;

class AuthService
{
    private $user;

    private $userModel;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function user()
    {
        if (!$this->userModel) {
            $this->userModel = $this->user->getOne((new User())->setId($_SESSION['user']));
        }

        return $this->userModel;
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password)
    {
        try {
            $user = $this->user->getOne((new User())->setEmailAddress($email));
        } catch (\Exception $e) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user->getId();
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}
