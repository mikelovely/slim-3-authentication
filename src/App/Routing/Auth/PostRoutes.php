<?php

namespace App\Routing\Auth;

use App\User\User;
use App\Routing\AbstractRoute;

class PostRoutes extends AbstractRoute
{
    private function mapPayloadToModel($payload)
    {
        return (new User())
            ->setName($payload->name)
            ->setEmailAddress($payload->email)
            ->setPassword(password_hash($payload->password, PASSWORD_DEFAULT));
    }

    public function postSignIn($request, $response)
    {
        $authService = $this->container->get('auth');
        $auth = $authService->attempt($request->getParam('email'), $request->getParam('password'));

        if (!$auth) {
            $this->container->get('flash')->addMessage('error', 'Could not sign you in with those details.');
            return $response->withRedirect($this->container->get('router')->pathFor('auth.signin'), 401);
        }

        return $response->withRedirect($this->container->get('router')->pathFor('home'));
    }

    public function postSignUp($request, $response)
    {
        $validator = $this->container->get('validator');
        $payload = $validator->validate($request, 'post_auth_signup');

        if ($validator->failed()) {
            return $response->withRedirect($this->container->get('router')->pathFor('auth.signup'), 302);
        }

        $userModel = $this->mapPayloadToModel($payload);
        $service = $this->container->get('user');
        $service->create($userModel);

        $this->container->get('flash')->addMessage('info', 'You have been signed up!');

        $this->container->get('auth')->attempt($userModel->getEmailAddress(), $request->getParam('password'));

        return $response->withRedirect($this->container->get('router')->pathFor('home'));
    }
}
