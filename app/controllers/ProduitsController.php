<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ProduitsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('produit', new Produits());
    }

    /**
     * Searches for produits
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Produits', $_GET)->getParams();
        $parameters['order'] = "ID_PRODUIT";

        $paginator   = new Model(
            [
                'model'      => 'Produits',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any produits");

            $this->dispatcher->forward([
                "controller" => "produits",
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
        $this->view->setVar('produit', new Produits());
    }

    /**
     * Edits a produit
     *
     * @param string $ID_PRODUIT
     */
    public function editAction($ID_PRODUIT)
    {
        if (!$this->request->isPost()) {
            $produit = Produits::findFirstByID_PRODUIT($ID_PRODUIT);
            if (!$produit) {
                $this->flash->error("produit was not found");

                $this->dispatcher->forward([
                    'controller' => "produits",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_PRODUIT = $produit->ID_PRODUIT;
            $this->view->setVar('produit', $produit);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new produit
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'index'
            ]);

            return;
        }

        $produit = new Produits();
        $produit->iDCATEGORIE = $this->request->getPost("ID_CATEGORIE");
        $produit->nOMPRODUIT = $this->request->getPost("NOM_PRODUIT");
        

        if (!$produit->save()) {
            foreach ($produit->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("produit was created successfully");

        $this->dispatcher->forward([
            'controller' => "produits",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a produit edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'index'
            ]);

            return;
        }

        $ID_PRODUIT = $this->request->getPost("ID_PRODUIT");
        $produit = Produits::findFirstByID_PRODUIT($ID_PRODUIT);

        if (!$produit) {
            $this->flash->error("produit does not exist " . $ID_PRODUIT);

            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'index'
            ]);

            return;
        }

        $produit->iDCATEGORIE = $this->request->getPost("ID_CATEGORIE");
        $produit->nOMPRODUIT = $this->request->getPost("NOM_PRODUIT");
        

        if (!$produit->save()) {

            foreach ($produit->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'edit',
                'params' => [$produit->ID_PRODUIT]
            ]);

            return;
        }

        $this->flash->success("produit was updated successfully");

        $this->dispatcher->forward([
            'controller' => "produits",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a produit
     *
     * @param string $ID_PRODUIT
     */
    public function deleteAction($ID_PRODUIT)
    {
        $produit = Produits::findFirstByID_PRODUIT($ID_PRODUIT);
        if (!$produit) {
            $this->flash->error("produit was not found");

            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'index'
            ]);

            return;
        }

        if (!$produit->delete()) {

            foreach ($produit->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "produits",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("produit was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "produits",
            'action' => "index"
        ]);
    }
}
