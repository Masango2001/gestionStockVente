<?php

class Approvisionnements extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $iD_APPROVISIONNEMENT;

    /**
     *
     * @var integer
     */
    public $iD_PRODUIT;

    /**
     *
     * @var integer
     */
    public $iD_FOURNISSEUR;

    /**
     *
     * @var string
     */
    public $qUANTITE_APPROVISIONNEMENT;

    /**
     *
     * @var double
     */
    public $pRIX_UNITAIRE_ACHAT;

    /**
     *
     * @var string
     */
    public $dATE_APPROVISIONNEMENT;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("approvisionnements");
        $this->belongsTo('iD_FOURNISSEUR', '\Fournisseurs', 'iD_FOURNISSEUR', ['alias' => 'Fournisseurs']);
        $this->belongsTo('iD_PRODUIT', '\Produits', 'iD_PRODUIT', ['alias' => 'Produits']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Approvisionnements[]|Approvisionnements|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Approvisionnements|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
