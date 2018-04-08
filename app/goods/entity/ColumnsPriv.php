<?php

namespace Frontend\Entity;

class ColumnsPriv extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var string
     * @Primary
     * @Column(column="Host", type="string", length=60, nullable=false)
     */
    protected $host;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="Db", type="string", length=64, nullable=false)
     */
    protected $db;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="User", type="string", length=32, nullable=false)
     */
    protected $user;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="Table_name", type="string", length=64, nullable=false)
     */
    protected $table_name;

    /**
     *
     * @var string
     * @Primary
     * @Column(column="Column_name", type="string", length=64, nullable=false)
     */
    protected $column_name;

    /**
     *
     * @var string
     * @Column(column="Timestamp", type="string", nullable=false)
     */
    protected $timestamp;

    /**
     *
     * @var string
     * @Column(column="Column_priv", type="string", nullable=false)
     */
    protected $column_priv;

    /**
     * Method to set the value of field host
     *
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

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
     * Method to set the value of field user
     *
     * @param string $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Method to set the value of field table_name
     *
     * @param string $table_name
     * @return $this
     */
    public function setTableName($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * Method to set the value of field column_name
     *
     * @param string $column_name
     * @return $this
     */
    public function setColumnName($column_name)
    {
        $this->column_name = $column_name;

        return $this;
    }

    /**
     * Method to set the value of field timestamp
     *
     * @param string $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Method to set the value of field column_priv
     *
     * @param string $column_priv
     * @return $this
     */
    public function setColumnPriv($column_priv)
    {
        $this->column_priv = $column_priv;

        return $this;
    }

    /**
     * Returns the value of field host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
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
     * Returns the value of field user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Returns the value of field table_name
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Returns the value of field column_name
     *
     * @return string
     */
    public function getColumnName()
    {
        return $this->column_name;
    }

    /**
     * Returns the value of field timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Returns the value of field column_priv
     *
     * @return string
     */
    public function getColumnPriv()
    {
        return $this->column_priv;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("columns_priv");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ColumnsPriv[]|ColumnsPriv|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ColumnsPriv|\Phalcon\Mvc\Model\ResultInterface
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
        return 'columns_priv';
    }

}
