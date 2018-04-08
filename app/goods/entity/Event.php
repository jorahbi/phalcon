<?php

namespace Frontend\Entity;

class Event extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="db", type="string", length=64, nullable=false)
     */
    protected $db;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="name", type="string", length=64, nullable=false)
     */
    protected $name;

    /**
     *
     * @var string
     * @Column(column="body", type="string", nullable=false)
     */
    protected $body;

    /**
     *
     * @var string
     * @Column(column="definer", type="string", length=93, nullable=false)
     */
    protected $definer;

    /**
     *
     * @var string
     * @Column(column="execute_at", type="string", nullable=true)
     */
    protected $execute_at;

    /**
     *
     * @var integer
     * @Column(column="interval_value", type="integer", length=11, nullable=true)
     */
    protected $interval_value;

    /**
     *
     * @var string
     * @Column(column="interval_field", type="string", nullable=true)
     */
    protected $interval_field;

    /**
     *
     * @var string
     * @Column(column="created", type="string", nullable=false)
     */
    protected $created;

    /**
     *
     * @var string
     * @Column(column="modified", type="string", nullable=false)
     */
    protected $modified;

    /**
     *
     * @var string
     * @Column(column="last_executed", type="string", nullable=true)
     */
    protected $last_executed;

    /**
     *
     * @var string
     * @Column(column="starts", type="string", nullable=true)
     */
    protected $starts;

    /**
     *
     * @var string
     * @Column(column="ends", type="string", nullable=true)
     */
    protected $ends;

    /**
     *
     * @var string
     * @Column(column="status", type="string", nullable=false)
     */
    protected $status;

    /**
     *
     * @var string
     * @Column(column="on_completion", type="string", nullable=false)
     */
    protected $on_completion;

    /**
     *
     * @var string
     * @Column(column="sql_mode", type="string", nullable=false)
     */
    protected $sql_mode;

    /**
     *
     * @var string
     * @Column(column="comment", type="string", length=64, nullable=false)
     */
    protected $comment;

    /**
     *
     * @var integer
     * @Column(column="originator", type="integer", length=10, nullable=false)
     */
    protected $originator;

    /**
     *
     * @var string
     * @Column(column="time_zone", type="string", length=64, nullable=false)
     */
    protected $time_zone;

    /**
     *
     * @var string
     * @Column(column="character_set_client", type="string", length=32, nullable=true)
     */
    protected $character_set_client;

    /**
     *
     * @var string
     * @Column(column="collation_connection", type="string", length=32, nullable=true)
     */
    protected $collation_connection;

    /**
     *
     * @var string
     * @Column(column="db_collation", type="string", length=32, nullable=true)
     */
    protected $db_collation;

    /**
     *
     * @var string
     * @Column(column="body_utf8", type="string", nullable=true)
     */
    protected $body_utf8;

    /**
     * Method to set the value of field db
     *
     * @param string $db
     * @return $this
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }

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
     * Method to set the value of field body
     *
     * @param string $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Method to set the value of field definer
     *
     * @param string $definer
     * @return $this
     */
    public function setDefiner($definer)
    {
        $this->definer = $definer;

        return $this;
    }

    /**
     * Method to set the value of field execute_at
     *
     * @param string $execute_at
     * @return $this
     */
    public function setExecuteAt($execute_at)
    {
        $this->execute_at = $execute_at;

        return $this;
    }

    /**
     * Method to set the value of field interval_value
     *
     * @param integer $interval_value
     * @return $this
     */
    public function setIntervalValue($interval_value)
    {
        $this->interval_value = $interval_value;

        return $this;
    }

    /**
     * Method to set the value of field interval_field
     *
     * @param string $interval_field
     * @return $this
     */
    public function setIntervalField($interval_field)
    {
        $this->interval_field = $interval_field;

        return $this;
    }

    /**
     * Method to set the value of field created
     *
     * @param string $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Method to set the value of field modified
     *
     * @param string $modified
     * @return $this
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Method to set the value of field last_executed
     *
     * @param string $last_executed
     * @return $this
     */
    public function setLastExecuted($last_executed)
    {
        $this->last_executed = $last_executed;

        return $this;
    }

    /**
     * Method to set the value of field starts
     *
     * @param string $starts
     * @return $this
     */
    public function setStarts($starts)
    {
        $this->starts = $starts;

        return $this;
    }

    /**
     * Method to set the value of field ends
     *
     * @param string $ends
     * @return $this
     */
    public function setEnds($ends)
    {
        $this->ends = $ends;

        return $this;
    }

    /**
     * Method to set the value of field status
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Method to set the value of field on_completion
     *
     * @param string $on_completion
     * @return $this
     */
    public function setOnCompletion($on_completion)
    {
        $this->on_completion = $on_completion;

        return $this;
    }

    /**
     * Method to set the value of field sql_mode
     *
     * @param string $sql_mode
     * @return $this
     */
    public function setSqlMode($sql_mode)
    {
        $this->sql_mode = $sql_mode;

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
     * Method to set the value of field originator
     *
     * @param integer $originator
     * @return $this
     */
    public function setOriginator($originator)
    {
        $this->originator = $originator;

        return $this;
    }

    /**
     * Method to set the value of field time_zone
     *
     * @param string $time_zone
     * @return $this
     */
    public function setTimeZone($time_zone)
    {
        $this->time_zone = $time_zone;

        return $this;
    }

    /**
     * Method to set the value of field character_set_client
     *
     * @param string $character_set_client
     * @return $this
     */
    public function setCharacterSetClient($character_set_client)
    {
        $this->character_set_client = $character_set_client;

        return $this;
    }

    /**
     * Method to set the value of field collation_connection
     *
     * @param string $collation_connection
     * @return $this
     */
    public function setCollationConnection($collation_connection)
    {
        $this->collation_connection = $collation_connection;

        return $this;
    }

    /**
     * Method to set the value of field db_collation
     *
     * @param string $db_collation
     * @return $this
     */
    public function setDbCollation($db_collation)
    {
        $this->db_collation = $db_collation;

        return $this;
    }

    /**
     * Method to set the value of field body_utf8
     *
     * @param string $body_utf8
     * @return $this
     */
    public function setBodyUtf8($body_utf8)
    {
        $this->body_utf8 = $body_utf8;

        return $this;
    }

    /**
     * Returns the value of field db
     *
     * @return string
     */
    public function getDb()
    {
        return $this->db;
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
     * Returns the value of field body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Returns the value of field definer
     *
     * @return string
     */
    public function getDefiner()
    {
        return $this->definer;
    }

    /**
     * Returns the value of field execute_at
     *
     * @return string
     */
    public function getExecuteAt()
    {
        return $this->execute_at;
    }

    /**
     * Returns the value of field interval_value
     *
     * @return integer
     */
    public function getIntervalValue()
    {
        return $this->interval_value;
    }

    /**
     * Returns the value of field interval_field
     *
     * @return string
     */
    public function getIntervalField()
    {
        return $this->interval_field;
    }

    /**
     * Returns the value of field created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Returns the value of field modified
     *
     * @return string
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Returns the value of field last_executed
     *
     * @return string
     */
    public function getLastExecuted()
    {
        return $this->last_executed;
    }

    /**
     * Returns the value of field starts
     *
     * @return string
     */
    public function getStarts()
    {
        return $this->starts;
    }

    /**
     * Returns the value of field ends
     *
     * @return string
     */
    public function getEnds()
    {
        return $this->ends;
    }

    /**
     * Returns the value of field status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Returns the value of field on_completion
     *
     * @return string
     */
    public function getOnCompletion()
    {
        return $this->on_completion;
    }

    /**
     * Returns the value of field sql_mode
     *
     * @return string
     */
    public function getSqlMode()
    {
        return $this->sql_mode;
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
     * Returns the value of field originator
     *
     * @return integer
     */
    public function getOriginator()
    {
        return $this->originator;
    }

    /**
     * Returns the value of field time_zone
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->time_zone;
    }

    /**
     * Returns the value of field character_set_client
     *
     * @return string
     */
    public function getCharacterSetClient()
    {
        return $this->character_set_client;
    }

    /**
     * Returns the value of field collation_connection
     *
     * @return string
     */
    public function getCollationConnection()
    {
        return $this->collation_connection;
    }

    /**
     * Returns the value of field db_collation
     *
     * @return string
     */
    public function getDbCollation()
    {
        return $this->db_collation;
    }

    /**
     * Returns the value of field body_utf8
     *
     * @return string
     */
    public function getBodyUtf8()
    {
        return $this->body_utf8;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("event");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event[]|Event|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event|\Phalcon\Mvc\Model\ResultInterface
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
        return 'event';
    }

}
