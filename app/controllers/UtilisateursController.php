<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class UtilisateursController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('utilisateur', new Utilisateurs());
    }

    /**
     * Searches for utilisateurs
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Utilisateurs', $_GET)->getParams();
        $parameters['order'] = "ID_UTILISATEUR";

        $paginator   = new Model(
            [
                'model'      => 'Utilisateurs',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any utilisateurs");

            $this->dispatcher->forward([
                "controller" => "utilisateurs",
                "action" => "index"
            ]);

            return;
        }

        $this->view->page = $paginate;
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {
        $this->view->setVar('utilisateur', new Utilisateurs());
    }

    /**
     * Edits a utilisateur
     *
     * @param string $ID_UTILISATEUR
     */
    public function editAction($ID_UTILISATEUR)
    {
        if (!$this->request->isPost()) {
            $utilisateur = Utilisateurs::findFirstByID_UTILISATEUR($ID_UTILISATEUR);
            if (!$utilisateur) {
                $this->flash->error("utilisateur was not found");

                $this->dispatcher->forward([
                    'controller' => "utilisateurs",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_UTILISATEUR = $utilisateur->ID_UTILISATEUR;
            $this->view->setVar('utilisateur', $utilisateur);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new utilisateur
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'index'
            ]);

            return;
        }

        $utilisateur = new Utilisateurs();
        $utilisateur->USERNAME = $this->request->getPost("USERNAME");
        $utilisateur->EMAIL = $this->request->getPost("EMAIL");
        $utilisateur->PASSWORD = $this->request->getPost("PASSWORD");
        $utilisateur->ROLE = $this->request->getPost("ROLE")?? "Vendeur";
        

        if (!$utilisateur->save()) {
            foreach ($utilisateur->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("utilisateur was created successfully");

        $this->dispatcher->forward([
            'controller' => "utilisateurs",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a utilisateur edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'index'
            ]);

            return;
        }

        $ID_UTILISATEUR = $this->request->getPost("ID_UTILISATEUR");
        $utilisateur = Utilisateurs::findFirstByID_UTILISATEUR($ID_UTILISATEUR);

        if (!$utilisateur) {
            $this->flash->error("utilisateur does not exist " . $ID_UTILISATEUR);

            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'index'
            ]);

            return;
        }

        $utilisateur->uSERNAME = $this->request->getPost("USERNAME");
        $utilisateur->eMAIL = $this->request->getPost("EMAIL");
        $utilisateur->pASSWORD = $this->request->getPost("PASSWORD");
        $utilisateur->rOLE = $this->request->getPost("ROLE");
        

        if (!$utilisateur->save()) {

            foreach ($utilisateur->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'edit',
                'params' => [$utilisateur->ID_UTILISATEUR]
            ]);

            return;
        }

        $this->flash->success("utilisateur was updated successfully");

        $this->dispatcher->forward([
            'controller' => "utilisateurs",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a utilisateur
     *
     * @param string $ID_UTILISATEUR
     */
    public function deleteAction($ID_UTILISATEUR)
    {
        $utilisateur = Utilisateurs::findFirstByID_UTILISATEUR($ID_UTILISATEUR);
        if (!$utilisateur) {
            $this->flash->error("utilisateur was not found");

            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'index'
            ]);

            return;
        }

        if (!$utilisateur->delete()) {

            foreach ($utilisateur->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "utilisateurs",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("utilisateur was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "utilisateurs",
            'action' => "index"
        ]);
    }
}
