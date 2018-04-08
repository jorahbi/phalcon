<?php

namespace Frontend\Entity;

class Func extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="name", type="string", length=64, nullable=false)
     */
    protected $name;

    /**
     *
     * @var integer
     * @Column(column="ret", type="integer", length=1, nullable=false)
     */
    protected $ret;

    /**
     *
     * @var string
     * @Column(column="dl", type="string", length=128, nullable=false)
     */
    protected $dl;

    /**
     *
     * @var string
     * @Column(column="type", type="string", nullable=false)
     */
    protected $type;

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field ret
     *
     * @param integer $ret
     * @return $this
     */
    public function setRet($ret)
    {
        $this->ret = $ret;

        return $this;
    }

    /**
     * Method to set the value of field dl
     *
     * @param string $dl
     * @return $this
     */
    public function setDl($dl)
    {
        $this->dl = $dl;

        return $this;
    }

    /**
     * Method to set the value of field type
     *
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field ret
     *
     * @return integer
     */
    public function getRet()
    {
        return $this->ret;
    }

    /**
     * Returns the value of field dl
     *
     * @return string
     */
    public function getDl()
    {
        return $this->dl;
    }

    /**
     * Returns the value of field type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("func");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Func[]|Func|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Func|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'func';
    }

}
