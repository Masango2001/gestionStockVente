<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ApprovisionnementsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('approvisionnement', new Approvisionnements());
    }

    /**
     * Searches for approvisionnements
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Approvisionnements', $_GET)->getParams();
        $parameters['order'] = "ID_APPROVISIONNEMENT";

        $paginator   = new Model(
            [
                'model'      => 'Approvisionnements',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any approvisionnements");

            $this->dispatcher->forward([
                "controller" => "approvisionnements",
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
        $this->view->setVar('approvisionnement', new Approvisionnements());
    }

    /**
     * Edits a approvisionnement
     *
     * @param string $ID_APPROVISIONNEMENT
     */
    public function editAction($ID_APPROVISIONNEMENT)
    {
        if (!$this->request->isPost()) {
            $approvisionnement = Approvisionnements::findFirstByID_APPROVISIONNEMENT($ID_APPROVISIONNEMENT);
            if (!$approvisionnement) {
                $this->flash->error("approvisionnement was not found");

                $this->dispatcher->forward([
                    'controller' => "approvisionnements",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_APPROVISIONNEMENT = $approvisionnement->ID_APPROVISIONNEMENT;
            $this->view->setVar('approvisionnement', $approvisionnement);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new approvisionnement
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'index'
            ]);

            return;
        }

        $approvisionnement = new Approvisionnements();
        $approvisionnement->iDPRODUIT = $this->request->getPost("ID_PRODUIT");
        $approvisionnement->iDFOURNISSEUR = $this->request->getPost("ID_FOURNISSEUR");
        $approvisionnement->qUANTITEAPPROVISIONNEMENT = $this->request->getPost("QUANTITE_APPROVISIONNEMENT");
        $approvisionnement->pRIXUNITAIREACHAT = $this->request->getPost("PRIX_UNITAIRE_ACHAT", "int");
        $approvisionnement->dATEAPPROVISIONNEMENT = $this->request->getPost("DATE_APPROVISIONNEMENT");
        

        if (!$approvisionnement->save()) {
            foreach ($approvisionnement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("approvisionnement was created successfully");

        $this->dispatcher->forward([
            'controller' => "approvisionnements",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a approvisionnement edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'index'
            ]);

            return;
        }

        $ID_APPROVISIONNEMENT = $this->request->getPost("ID_APPROVISIONNEMENT");
        $approvisionnement = Approvisionnements::findFirstByID_APPROVISIONNEMENT($ID_APPROVISIONNEMENT);

        if (!$approvisionnement) {
            $this->flash->error("approvisionnement does not exist " . $ID_APPROVISIONNEMENT);

            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'index'
            ]);

            return;
        }

        $approvisionnement->iDPRODUIT = $this->request->getPost("ID_PRODUIT");
        $approvisionnement->iDFOURNISSEUR = $this->request->getPost("ID_FOURNISSEUR");
        $approvisionnement->qUANTITEAPPROVISIONNEMENT = $this->request->getPost("QUANTITE_APPROVISIONNEMENT");
        $approvisionnement->pRIXUNITAIREACHAT = $this->request->getPost("PRIX_UNITAIRE_ACHAT", "int");
        $approvisionnement->dATEAPPROVISIONNEMENT = $this->request->getPost("DATE_APPROVISIONNEMENT");
        

        if (!$approvisionnement->save()) {

            foreach ($approvisionnement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'edit',
                'params' => [$approvisionnement->ID_APPROVISIONNEMENT]
            ]);

            return;
        }

        $this->flash->success("approvisionnement was updated successfully");

        $this->dispatcher->forward([
            'controller' => "approvisionnements",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a approvisionnement
     *
     * @param string $ID_APPROVISIONNEMENT
     */
    public function deleteAction($ID_APPROVISIONNEMENT)
    {
        $approvisionnement = Approvisionnements::findFirstByID_APPROVISIONNEMENT($ID_APPROVISIONNEMENT);
        if (!$approvisionnement) {
            $this->flash->error("approvisionnement was not found");

            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'index'
            ]);

            return;
        }

        if (!$approvisionnement->delete()) {

            foreach ($approvisionnement->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "approvisionnements",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("approvisionnement was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "approvisionnements",
            'action' => "index"
        ]);
    }
}
