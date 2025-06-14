<?php

class Produits extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ID_PRODUIT;

    /**
     *
     * @var integer
     */
    public $ID_CATEGORIE;

    /**
     *
     * @var string
     */
    public $NOM_PRODUIT;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("produits");
        $this->hasMany('ID_PRODUIT', 'Approvisionnements', 'ID_PRODUIT', ['alias' => 'Approvisionnements']);
        $this->hasMany('ID_PRODUIT', 'Concerner', 'ID_PRODUIT', ['alias' => 'Concerner']);
        $this->hasMany('ID_PRODUIT', 'Stocks', 'ID_PRODUIT', ['alias' => 'Stocks']);
        $this->belongsTo('ID_CATEGORIE', '\Categories', 'ID_CATEGORIE', ['alias' => 'Categories']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Produits[]|Produits|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Produits|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
