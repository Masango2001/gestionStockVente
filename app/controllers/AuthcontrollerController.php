<?php

use Phalcon\Mvc\Controller;
use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Security;

class AuthController extends Controller
{
    public function loginAction()
    {
        if ($this->request->isPost()) {
            $username = $this->request->getPost('username', 'string');
            $password = $this->request->getPost('password', 'string');

            $user = Utilisateurs::findFirst([
                'conditions' => 'USERNAME = :username:',
                'bind' => ['username' => $username]
            ]);

            $security = new Security();
            if ($user && $security->checkHash($password, $user->PASSWORD)) {
                $this->session->set('auth', [
                    'id' => $user->ID_UTILISATEUR,
                    'username' => $user->USERNAME,
                    'role' => $user->ROLE
                ]);

                switch ($user->ROLE) {
                    case 'admin':
                        return $this->response->redirect('/admin');
                    case 'vendeur':
                        return $this->response->redirect('/vente');
                    case 'magasinier':
                        return $this->response->redirect('/stock');
                    default:
                        $this->session->destroy();
                        $this->flash->error('Invalid role');
                        return $this->response->redirect('/login');
                }
            } else {
                $this->flash->error('Invalid credentials');
                return $this->response->redirect('/login');
            }
        }

        return $this->view->pick('auth/login');
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->response->redirect('/login');
    }
}