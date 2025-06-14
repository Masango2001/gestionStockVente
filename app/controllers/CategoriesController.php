<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class CategoriesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('categorie', new Categories());
    }

    /**
     * Searches for categories
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Categories', $_GET)->getParams();
        $parameters['order'] = "ID_CATEGORIE";

        $paginator   = new Model(
            [
                'model'      => 'Categories',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any categories");

            $this->dispatcher->forward([
                "controller" => "categories",
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
        $this->view->setVar('categorie', new Categories());
    }

    /**
     * Edits a categorie
     *
     * @param string $ID_CATEGORIE
     */
    public function editAction($ID_CATEGORIE)
    {
        if (!$this->request->isPost()) {
            $categorie = Categories::findFirstByID_CATEGORIE($ID_CATEGORIE);
            if (!$categorie) {
                $this->flash->error("categorie was not found");

                $this->dispatcher->forward([
                    'controller' => "categories",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_CATEGORIE = $categorie->ID_CATEGORIE;
            $this->view->setVar('categorie', $categorie);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new categorie
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $categorie = new Categories();
        $categorie->nOMCATEGORIE = $this->request->getPost("NOM_CATEGORIE");
        

        if (!$categorie->save()) {
            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("categorie was created successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a categorie edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $ID_CATEGORIE = $this->request->getPost("ID_CATEGORIE");
        $categorie = Categories::findFirstByID_CATEGORIE($ID_CATEGORIE);

        if (!$categorie) {
            $this->flash->error("categorie does not exist " . $ID_CATEGORIE);

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        $categorie->nOMCATEGORIE = $this->request->getPost("NOM_CATEGORIE");
        

        if (!$categorie->save()) {

            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'edit',
                'params' => [$categorie->ID_CATEGORIE]
            ]);

            return;
        }

        $this->flash->success("categorie was updated successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a categorie
     *
     * @param string $ID_CATEGORIE
     */
    public function deleteAction($ID_CATEGORIE)
    {
        $categorie = Categories::findFirstByID_CATEGORIE($ID_CATEGORIE);
        if (!$categorie) {
            $this->flash->error("categorie was not found");

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'index'
            ]);

            return;
        }

        if (!$categorie->delete()) {

            foreach ($categorie->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "categories",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("categorie was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "categories",
            'action' => "index"
        ]);
    }
}
