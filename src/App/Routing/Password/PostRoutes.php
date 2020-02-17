<?php

namespace App\Routing\Password;

use App\User\User;
use App\Routing\AbstractRoute;

class PostRoutes extends AbstractRoute
{
    private function mapPayloadToModel(User $model, $payload): User
    {
        if (property_exists($payload, 'password')) {
            $model->setPassword(password_hash($payload->password, PASSWORD_BCRYPT));
        }

        return $model;
    }

    public function postChangePassword($request, $response)
    {
        $validator = $this->container->get('validator');
        $payload = $validator->validate($request, 'post_auth_password_change');

        if ($validator->failed()) {
            return $response->withRedirect($this->container->get('router')->pathFor('auth.password.change'));
        }

        $user = $this->container->get('auth')->user();

        try {
            $this->checkPassword($payload->password_old, $user->getPassword());
        } catch (\Exception $e) {
            $this->container->get('flash')->addMessage('error', 'Your password was incorrect.');
            return $response->withRedirect($this->container->get('router')->pathFor('auth.password.change'));
        }

        $user = $this->mapPayloadToModel($user, $payload);
        $user = $this->container->get('user')->update($user);

        $this->container->get('flash')->addMessage('info', 'Your password was changed.');

        return $response->withRedirect($this->container->get('router')->pathFor('home'));
    }

    private function checkPassword(string $challenge, string $stored)
    {
        if (!password_verify($challenge, $stored)) {
            throw new \Exception();
        }
    }
}
