<?php

class Clients extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $iD_CLIENT;

    /**
     *
     * @var string
     */
    public $NOM_CLIENT;

    /**
     *
     * @var string
     */
    public $PRENOM_CLIENT;

    /**
     *
     * @var string
     */
    public $ADRESSE_CLIENT;

    /**
     *
     * @var string
     */
    public $TELEPHONE_CLIENT;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("clients");
        $this->hasMany('iD_CLIENT', 'Ventes', 'iD_CLIENT', ['alias' => 'Ventes']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clients[]|Clients|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Clients|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
