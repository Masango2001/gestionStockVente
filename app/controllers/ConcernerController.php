<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ConcernerController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('concerner', new Concerner());
    }

    /**
     * Searches for concerner
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Concerner', $_GET)->getParams();
        $parameters['order'] = "ID_PRODUIT";

        $paginator   = new Model(
            [
                'model'      => 'Concerner',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any concerner");

            $this->dispatcher->forward([
                "controller" => "concerner",
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
        $this->view->setVar('concerner', new Concerner());
    }

    /**
     * Edits a concerner
     *
     * @param string $ID_PRODUIT
     */
    public function editAction($ID_PRODUIT)
    {
        if (!$this->request->isPost()) {
            $concerner = Concerner::findFirstByID_PRODUIT($ID_PRODUIT);
            if (!$concerner) {
                $this->flash->error("concerner was not found");

                $this->dispatcher->forward([
                    'controller' => "concerner",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_PRODUIT = $concerner->ID_PRODUIT;
            $this->view->setVar('concerner', $concerner);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new concerner
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'index'
            ]);

            return;
        }

        $concerner = new Concerner();
        $concerner->ID_VENTE = $this->request->getPost("ID_VENTE");
        $concerner->ID_PRODUIT = $this->request->getPost("ID_PRODUIT");
        $concerner->QUANTITE_VENDUE = $this->request->getPost("QUANTITE_VENDUE");
        $concerner->PRIX_UNITAIRE_VENDUE = $this->request->getPost("PRIX_UNITAIRE_VENDUE", "int");


        if (!$concerner->save()) {
            foreach ($concerner->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("concerner was created successfully");

        $this->dispatcher->forward([
            'controller' => "concerner",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a concerner edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'index'
            ]);

            return;
        }

        $ID_PRODUIT = $this->request->getPost("ID_PRODUIT");
        $concerner = Concerner::findFirstByID_PRODUIT($ID_PRODUIT);

        if (!$concerner) {
            $this->flash->error("concerner does not exist " . $ID_PRODUIT);

            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'index'
            ]);

            return;
        }

        $concerner->ID_VENTE = $this->request->getPost("ID_VENTE");

        $concerner->ID_PRODUIT = $this->request->getPost("ID_PRODUIT");
        $concerner->QUANTITE_VENDUE = $this->request->getPost("QUANTITE_VENDUE");
        $concerner->PRIX_UNITAIRE_VENDUE = $this->request->getPost("PRIX_UNITAIRE_VENDUE", "int");


        if (!$concerner->save()) {

            foreach ($concerner->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'edit',
                'params' => [$concerner->ID_PRODUIT]
            ]);

            return;
        }

        $this->flash->success("concerner was updated successfully");

        $this->dispatcher->forward([
            'controller' => "concerner",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a concerner
     *
     * @param string $ID_PRODUIT
     */
    public function deleteAction($ID_PRODUIT)
    {
        $concerner = Concerner::findFirstByID_PRODUIT($ID_PRODUIT);
        if (!$concerner) {
            $this->flash->error("concerner was not found");

            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'index'
            ]);

            return;
        }

        if (!$concerner->delete()) {

            foreach ($concerner->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "concerner",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("concerner was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "concerner",
            'action' => "index"
        ]);
    }
}
