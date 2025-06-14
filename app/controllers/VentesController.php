<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class VentesController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('vente', new Ventes());
    }

    /**
     * Searches for ventes
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Ventes', $_GET)->getParams();
        $parameters['order'] = "ID_VENTE";

        $paginator   = new Model(
            [
                'model'      => 'Ventes',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any ventes");

            $this->dispatcher->forward([
                "controller" => "ventes",
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
        $this->view->setVar('vente', new Ventes());
    }

    /**
     * Edits a vente
     *
     * @param string $ID_VENTE
     */
    public function editAction($ID_VENTE)
    {
        if (!$this->request->isPost()) {
            $vente = Ventes::findFirstByID_VENTE($ID_VENTE);
            if (!$vente) {
                $this->flash->error("vente was not found");

                $this->dispatcher->forward([
                    'controller' => "ventes",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_VENTE = $vente->ID_VENTE;
            $this->view->setVar('vente', $vente);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new vente
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'index'
            ]);

            return;
        }

        $vente = new Ventes();
        $vente->ID_UTILISATEUR = $this->request->getPost("ID_UTILISATEUR");
        $vente->ID_CLIENT = $this->request->getPost("ID_CLIENT");
        $vente->DATE_VENTE = $this->request->getPost("DATE_VENTE");
    

        if (!$vente->save()) {
            foreach ($vente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("vente was created successfully");

        $this->dispatcher->forward([
            'controller' => "ventes",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a vente edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'index'
            ]);

            return;
        }

        $ID_VENTE = $this->request->getPost("ID_VENTE");
        $vente = Ventes::findFirstByID_VENTE($ID_VENTE);

        if (!$vente) {
            $this->flash->error("vente does not exist " . $ID_VENTE);

            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'index'
            ]);

            return;
        }

        $vente->ID_UTILISATEUR = $this->request->getPost("ID_UTILISATEUR");
        $vente->ID_CLIENT = $this->request->getPost("ID_CLIENT");
        $vente->DATE_VENTE = $this->request->getPost("DATE_VENTE");
        

        if (!$vente->save()) {

            foreach ($vente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'edit',
                'params' => [$vente->ID_VENTE]
            ]);

            return;
        }

        $this->flash->success("vente was updated successfully");

        $this->dispatcher->forward([
            'controller' => "ventes",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a vente
     *
     * @param string $ID_VENTE
     */
    public function deleteAction($ID_VENTE)
    {
        $vente = Ventes::findFirstByID_VENTE($ID_VENTE);
        if (!$vente) {
            $this->flash->error("vente was not found");

            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'index'
            ]);

            return;
        }

        if (!$vente->delete()) {

            foreach ($vente->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "ventes",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("vente was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "ventes",
            'action' => "index"
        ]);
    }
}
