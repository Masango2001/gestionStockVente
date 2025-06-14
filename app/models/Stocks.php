<?php

class Stocks extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ID_STOCK;

    /**
     *
     * @var integer
     */
    public $ID_PRODUIT;

    /**
     *
     * @var string
     */
    public $QUANTITE_STOCK;

    /**
     *
     * @var string
     */
    public $DATE_MISEJOUR;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("stocks");
        $this->belongsTo('ID_PRODUIT', '\Produits', 'iD_PRODUIT', ['alias' => 'Produits']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stocks[]|Stocks|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Stocks|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
