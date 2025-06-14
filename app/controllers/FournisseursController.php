<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class FournisseursController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('fournisseur', new Fournisseurs());
    }

    /**
     * Searches for fournisseurs
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Fournisseurs', $_GET)->getParams();
        $parameters['order'] = "ID_FOURNISSEUR";

        $paginator   = new Model(
            [
                'model'      => 'Fournisseurs',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any fournisseurs");

            $this->dispatcher->forward([
                "controller" => "fournisseurs",
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
        $this->view->setVar('fournisseur', new Fournisseurs());
    }

    /**
     * Edits a fournisseur
     *
     * @param string $ID_FOURNISSEUR
     */
    public function editAction($ID_FOURNISSEUR)
    {
        if (!$this->request->isPost()) {
            $fournisseur = Fournisseurs::findFirstByID_FOURNISSEUR($ID_FOURNISSEUR);
            if (!$fournisseur) {
                $this->flash->error("fournisseur was not found");

                $this->dispatcher->forward([
                    'controller' => "fournisseurs",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_FOURNISSEUR = $fournisseur->ID_FOURNISSEUR;
            $this->view->setVar('fournisseur', $fournisseur);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new fournisseur
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'index'
            ]);

            return;
        }

        $fournisseur = new Fournisseurs();
        $fournisseur->NOM_COMPLET_FOURNISSEUR = $this->request->getPost("NOM_COMPLET_FOURNISSEUR");
        $fournisseur->ADRESSE_FOURNISSEUR = $this->request->getPost("ADRESSE_FOURNISSEUR");
        $fournisseur->EMAIL_FOURNISSEUR = $this->request->getPost("EMAIL_FOURNISSEUR");
        $fournisseur->TELEPHONE_FOURNISSEUR = $this->request->getPost("TELEPHONE_FOURNISSEUR");
        

        if (!$fournisseur->save()) {
        

foreach ($fournisseur->getMessages() as $message) {
    $this->flash->error($message->getMessage());
}


            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("fournisseur was created successfully");

        $this->dispatcher->forward([
            'controller' => "fournisseurs",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a fournisseur edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'index'
            ]);

            return;
        }

        $ID_FOURNISSEUR = $this->request->getPost("ID_FOURNISSEUR");
        $fournisseur = Fournisseurs::findFirstByID_FOURNISSEUR($ID_FOURNISSEUR);

        if (!$fournisseur) {
            $this->flash->error("fournisseur does not exist " . $ID_FOURNISSEUR);

            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'index'
            ]);

            return;
        }

        $fournisseur->NOM_COMPLET_FOURNISSEUR = $this->request->getPost("NOM_COMPLET_FOURNISSEUR");
        $fournisseur->ADRESSE_FOURNISSEUR = $this->request->getPost("ADRESSE_FOURNISSEUR");
        $fournisseur->EMAIL_FOURNISSEUR = $this->request->getPost("EMAIL_FOURNISSEUR");
        $fournisseur->TELEPHONE_FOURNISSEUR = $this->request->getPost("TELEPHONE_FOURNISSEUR");
        

      if (!$fournisseur->save()) {
    foreach ($fournisseur->getMessages() as $message) {
        $this->flash->error($message->getMessage());
    }
    $this->dispatcher->forward([
        'controller' => "fournisseurs",
        'action' => 'edit',
        'params' => [$fournisseur->ID_FOURNISSEUR]
    ]);
    return;
}

        $this->flash->success("fournisseur was updated successfully");

        $this->dispatcher->forward([
            'controller' => "fournisseurs",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a fournisseur
     *
     * @param string $ID_FOURNISSEUR
     */
    public function deleteAction($ID_FOURNISSEUR)
    {
        $fournisseur = Fournisseurs::findFirstByID_FOURNISSEUR($ID_FOURNISSEUR);
        if (!$fournisseur) {
            $this->flash->error("fournisseur was not found");

            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'index'
            ]);

            return;
        }

        if (!$fournisseur->delete()) {

            foreach ($fournisseur->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "fournisseurs",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("fournisseur was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "fournisseurs",
            'action' => "index"
        ]);
    }
}
