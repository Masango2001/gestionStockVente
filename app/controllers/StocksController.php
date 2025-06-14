<?php
declare(strict_types=1);

 

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model;


class StocksController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->view->setVar('stock', new Stocks());
    }

    /**
     * Searches for stocks
     */
    public function searchAction()
    {
        $numberPage = $this->request->getQuery('page', 'int', 1);
        $parameters = Criteria::fromInput($this->di, 'Stocks', $_GET)->getParams();
        $parameters['order'] = "ID_STOCK";

        $paginator   = new Model(
            [
                'model'      => 'Stocks',
                'parameters' => $parameters,
                'limit'      => 10,
                'page'       => $numberPage,
            ]
        );

        $paginate = $paginator->paginate();

        if (0 === $paginate->getTotalItems()) {
            $this->flash->notice("The search did not find any stocks");

            $this->dispatcher->forward([
                "controller" => "stocks",
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
        $this->view->setVar('stock', new Stocks());
    }

    /**
     * Edits a stock
     *
     * @param string $ID_STOCK
     */
    public function editAction($ID_STOCK)
    {
        if (!$this->request->isPost()) {
            $stock = Stocks::findFirstByID_STOCK($ID_STOCK);
            if (!$stock) {
                $this->flash->error("stock was not found");

                $this->dispatcher->forward([
                    'controller' => "stocks",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->ID_STOCK = $stock->ID_STOCK;
            $this->view->setVar('stock', $stock);

            //$assignTagDefaults$
        }
    }

    /**
     * Creates a new stock
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'index'
            ]);

            return;
        }

        $stock = new Stocks();
        $stock->iDPRODUIT = $this->request->getPost("ID_PRODUIT");
        $stock->qUANTITESTOCK = $this->request->getPost("QUANTITE_STOCK");
        $stock->dATEMISEJOUR = $this->request->getPost("DATE_MISEJOUR");
        

        if (!$stock->save()) {
            foreach ($stock->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("stock was created successfully");

        $this->dispatcher->forward([
            'controller' => "stocks",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a stock edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'index'
            ]);

            return;
        }

        $ID_STOCK = $this->request->getPost("ID_STOCK");
        $stock = Stocks::findFirstByID_STOCK($ID_STOCK);

        if (!$stock) {
            $this->flash->error("stock does not exist " . $ID_STOCK);

            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'index'
            ]);

            return;
        }

        $stock->iDPRODUIT = $this->request->getPost("ID_PRODUIT");
        $stock->qUANTITESTOCK = $this->request->getPost("QUANTITE_STOCK");
        $stock->dATEMISEJOUR = $this->request->getPost("DATE_MISEJOUR");
        

        if (!$stock->save()) {

            foreach ($stock->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'edit',
                'params' => [$stock->ID_STOCK]
            ]);

            return;
        }

        $this->flash->success("stock was updated successfully");

        $this->dispatcher->forward([
            'controller' => "stocks",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a stock
     *
     * @param string $ID_STOCK
     */
    public function deleteAction($ID_STOCK)
    {
        $stock = Stocks::findFirstByID_STOCK($ID_STOCK);
        if (!$stock) {
            $this->flash->error("stock was not found");

            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'index'
            ]);

            return;
        }

        if (!$stock->delete()) {

            foreach ($stock->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "stocks",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("stock was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "stocks",
            'action' => "index"
        ]);
    }
}
