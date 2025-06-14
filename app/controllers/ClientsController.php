<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class ClientsController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('client', new Clients());
    }

    /**
     * Searches for clients
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Clients', $_GET)->getParams();
        $parameters['order'] = "ID_CLIENT";

        $paginator   = new Model(
            [
                'model'      => 'Clients',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any clients");

            $this->dispatcher->forward([
                "controller" => "clients",
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
        $this->view->setVar('client', new Clients());
    }

    /**
     * Edits a client
     *
     * @param string $ID_CLIENT
     */
    public function editAction($ID_CLIENT)
    {
        if (!$this->request->isPost()) {
            $client = Clients::findFirstByID_CLIENT($ID_CLIENT);
            if (!$client) {
                $this->flash->error("client was not found");

                $this->dispatcher->forward([
                    'controller' => "clients",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_CLIENT = $client->ID_CLIENT;
            $this->view->setVar('client', $client);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new client
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        $client = new Clients();
        $client->NOM_CLIENT = $this->request->getPost("NOM_CLIENT");
        $client->PRENOM_CLIENT = $this->request->getPost("PRENOM_CLIENT");
        $client->ADRESSE_CLIENT = $this->request->getPost("ADRESSE_CLIENT");
        $client->TELEPHONE_CLIENT = $this->request->getPost("TELEPHONE_CLIENT");
        

        if (!$client->save()) {
            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("client was created successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a client edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        $ID_CLIENT = $this->request->getPost("ID_CLIENT");
        $client = Clients::findFirstByID_CLIENT($ID_CLIENT);

        if (!$client) {
            $this->flash->error("client does not exist " . $ID_CLIENT);

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        $client->nOMCLIENT = $this->request->getPost("NOM_CLIENT");
        $client->pRENOMCLIENT = $this->request->getPost("PRENOM_CLIENT");
        $client->aDRESSECLIENT = $this->request->getPost("ADRESSE_CLIENT");
        $client->tELEPHONECLIENT = $this->request->getPost("TELEPHONE_CLIENT");
        

        if (!$client->save()) {

            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'edit',
                'params' => [$client->ID_CLIENT]
            ]);

            return;
        }

        $this->flash->success("client was updated successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a client
     *
     * @param string $ID_CLIENT
     */
    public function deleteAction($ID_CLIENT)
    {
        $client = Clients::findFirstByID_CLIENT($ID_CLIENT);
        if (!$client) {
            $this->flash->error("client was not found");

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'index'
            ]);

            return;
        }

        if (!$client->delete()) {

            foreach ($client->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "clients",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("client was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "clients",
            'action' => "index"
        ]);
    }
}
