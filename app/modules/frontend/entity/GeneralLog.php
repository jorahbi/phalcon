<?php

namespace Frontend\Entity;

class GeneralLog extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Column(column="event_time", type="string", length=6, nullable=false)
     */
    protected $event_time;

    /**
     *
     * @var string
     * @Column(column="user_host", type="string", nullable=false)
     */
    protected $user_host;

    /**
     *
     * @var integer
     * @Column(column="thread_id", type="integer", length=21, nullable=false)
     */
    protected $thread_id;

    /**
     *
     * @var integer
     * @Column(column="server_id", type="integer", length=10, nullable=false)
     */
    protected $server_id;

    /**
     *
     * @var string
     * @Column(column="command_type", type="string", length=64, nullable=false)
     */
    protected $command_type;

    /**
     *
     * @var string
     * @Column(column="argument", type="string", nullable=false)
     */
    protected $argument;

    /**
     * Method to set the value of field event_time
     *
     * @param string $event_time
     * @return $this
     */
    public function setEventTime($event_time)
    {
        $this->event_time = $event_time;

        return $this;
    }

    /**
     * Method to set the value of field user_host
     *
     * @param string $user_host
     * @return $this
     */
    public function setUserHost($user_host)
    {
        $this->user_host = $user_host;

        return $this;
    }

    /**
     * Method to set the value of field thread_id
     *
     * @param integer $thread_id
     * @return $this
     */
    public function setThreadId($thread_id)
    {
        $this->thread_id = $thread_id;

        return $this;
    }

    /**
     * Method to set the value of field server_id
     *
     * @param integer $server_id
     * @return $this
     */
    public function setServerId($server_id)
    {
        $this->server_id = $server_id;

        return $this;
    }

    /**
     * Method to set the value of field command_type
     *
     * @param string $command_type
     * @return $this
     */
    public function setCommandType($command_type)
    {
        $this->command_type = $command_type;

        return $this;
    }

    /**
     * Method to set the value of field argument
     *
     * @param string $argument
     * @return $this
     */
    public function setArgument($argument)
    {
        $this->argument = $argument;

        return $this;
    }

    /**
     * Returns the value of field event_time
     *
     * @return string
     */
    public function getEventTime()
    {
        return $this->event_time;
    }

    /**
     * Returns the value of field user_host
     *
     * @return string
     */
    public function getUserHost()
    {
        return $this->user_host;
    }

    /**
     * Returns the value of field thread_id
     *
     * @return integer
     */
    public function getThreadId()
    {
        return $this->thread_id;
    }

    /**
     * Returns the value of field server_id
     *
     * @return integer
     */
    public function getServerId()
    {
        return $this->server_id;
    }

    /**
     * Returns the value of field command_type
     *
     * @return string
     */
    public function getCommandType()
    {
        return $this->command_type;
    }

    /**
     * Returns the value of field argument
     *
     * @return string
     */
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("general_log");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return GeneralLog[]|GeneralLog|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return GeneralLog|\Phalcon\Mvc\Model\ResultInterface
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
        return 'general_log';
    }

}
