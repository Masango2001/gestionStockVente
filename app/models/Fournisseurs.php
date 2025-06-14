<?php

class Fournisseurs extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ID_FOURNISSEUR;

    /**
     *
     * @var string
     */
    public $NOM_COMPLET_FOURNISSEUR;

    /**
     *
     * @var string
     */
    public $ADRESSE_FOURNISSEUR;

    /**
     *
     * @var string
     */
    public $EMAIL_FOURNISSEUR;

    /**
     *
     * @var string
     */
    public $TELEPHONE_FOURNISSEUR;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("fournisseurs");
        $this->hasMany('ID_FOURNISSEUR', 'Approvisionnements', 'ID_FOURNISSEUR', ['alias' => 'Approvisionnements']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Fournisseurs[]|Fournisseurs|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Fournisseurs|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
