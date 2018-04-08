<?php

namespace Frontend\Entity;

class EngineCost extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="engine_name", type="string", length=64, nullable=false)
     */
    protected $engine_name;

    /**
     *
     * @var integer
     * @Primary
     * @Column(column="device_type", type="integer", length=11, nullable=false)
     */
    protected $device_type;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="cost_name", type="string", length=64, nullable=false)
     */
    protected $cost_name;

    /**
     *
     * @var double
     * @Column(column="cost_value", type="double", nullable=true)
     */
    protected $cost_value;

    /**
     *
     * @var string
     * @Column(column="last_update", type="string", nullable=false)
     */
    protected $last_update;

    /**
     *
     * @var string
     * @Column(column="comment", type="string", length=1024, nullable=true)
     */
    protected $comment;

    /**
     * Method to set the value of field engine_name
     *
     * @param string $engine_name
     * @return $this
     */
    public function setEngineName($engine_name)
    {
        $this->engine_name = $engine_name;

        return $this;
    }

    /**
     * Method to set the value of field device_type
     *
     * @param integer $device_type
     * @return $this
     */
    public function setDeviceType($device_type)
    {
        $this->device_type = $device_type;

        return $this;
    }

    /**
     * Method to set the value of field cost_name
     *
     * @param string $cost_name
     * @return $this
     */
    public function setCostName($cost_name)
    {
        $this->cost_name = $cost_name;

        return $this;
    }

    /**
     * Method to set the value of field cost_value
     *
     * @param double $cost_value
     * @return $this
     */
    public function setCostValue($cost_value)
    {
        $this->cost_value = $cost_value;

        return $this;
    }

    /**
     * Method to set the value of field last_update
     *
     * @param string $last_update
     * @return $this
     */
    public function setLastUpdate($last_update)
    {
        $this->last_update = $last_update;

        return $this;
    }

    /**
     * Method to set the value of field comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Returns the value of field engine_name
     *
     * @return string
     */
    public function getEngineName()
    {
        return $this->engine_name;
    }

    /**
     * Returns the value of field device_type
     *
     * @return integer
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }

    /**
     * Returns the value of field cost_name
     *
     * @return string
     */
    public function getCostName()
    {
        return $this->cost_name;
    }

    /**
     * Returns the value of field cost_value
     *
     * @return double
     */
    public function getCostValue()
    {
        return $this->cost_value;
    }

    /**
     * Returns the value of field last_update
     *
     * @return string
     */
    public function getLastUpdate()
    {
        return $this->last_update;
    }

    /**
     * Returns the value of field comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("engine_cost");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return EngineCost[]|EngineCost|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return EngineCost|\Phalcon\Mvc\Model\ResultInterface
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
        return 'engine_cost';
    }

}
