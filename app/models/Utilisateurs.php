<?php

class Utilisateurs extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $ID_UTILISATEUR;

    /**
     *
     * @var string
     */
    public $USERNAME;

    /**
     *
     * @var string
     */
    public $EMAIL;

    /**
     *
     * @var string
     */
    public $PASSWORD;

    /**
     *
     * @var string
     */
    public $ROLE;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("stocketvente");
        $this->setSource("utilisateurs");
        $this->hasMany('iD_UTILISATEUR', 'Ventes', 'iD_UTILISATEUR', ['alias' => 'Ventes']);
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Utilisateurs[]|Utilisateurs|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Utilisateurs|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
