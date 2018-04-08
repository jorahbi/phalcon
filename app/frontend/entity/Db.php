<?php

namespace Frontend\Entity;

class Db extends \Phalcon\Mvc\Model
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
     * @Column(column="Select_priv", type="string", nullable=false)
     */
    protected $select_priv;

    /**
     *
     * @var string
     * @Column(column="Insert_priv", type="string", nullable=false)
     */
    protected $insert_priv;

    /**
     *
     * @var string
     * @Column(column="Update_priv", type="string", nullable=false)
     */
    protected $update_priv;

    /**
     *
     * @var string
     * @Column(column="Delete_priv", type="string", nullable=false)
     */
    protected $delete_priv;

    /**
     *
     * @var string
     * @Column(column="Create_priv", type="string", nullable=false)
     */
    protected $create_priv;

    /**
     *
     * @var string
     * @Column(column="Drop_priv", type="string", nullable=false)
     */
    protected $drop_priv;

    /**
     *
     * @var string
     * @Column(column="Grant_priv", type="string", nullable=false)
     */
    protected $grant_priv;

    /**
     *
     * @var string
     * @Column(column="References_priv", type="string", nullable=false)
     */
    protected $references_priv;

    /**
     *
     * @var string
     * @Column(column="Index_priv", type="string", nullable=false)
     */
    protected $index_priv;

    /**
     *
     * @var string
     * @Column(column="Alter_priv", type="string", nullable=false)
     */
    protected $alter_priv;

    /**
     *
     * @var string
     * @Column(column="Create_tmp_table_priv", type="string", nullable=false)
     */
    protected $create_tmp_table_priv;

    /**
     *
     * @var string
     * @Column(column="Lock_tables_priv", type="string", nullable=false)
     */
    protected $lock_tables_priv;

    /**
     *
     * @var string
     * @Column(column="Create_view_priv", type="string", nullable=false)
     */
    protected $create_view_priv;

    /**
     *
     * @var string
     * @Column(column="Show_view_priv", type="string", nullable=false)
     */
    protected $show_view_priv;

    /**
     *
     * @var string
     * @Column(column="Create_routine_priv", type="string", nullable=false)
     */
    protected $create_routine_priv;

    /**
     *
     * @var string
     * @Column(column="Alter_routine_priv", type="string", nullable=false)
     */
    protected $alter_routine_priv;

    /**
     *
     * @var string
     * @Column(column="Execute_priv", type="string", nullable=false)
     */
    protected $execute_priv;

    /**
     *
     * @var string
     * @Column(column="Event_priv", type="string", nullable=false)
     */
    protected $event_priv;

    /**
     *
     * @var string
     * @Column(column="Trigger_priv", type="string", nullable=false)
     */
    protected $trigger_priv;

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
     * Method to set the value of field select_priv
     *
     * @param string $select_priv
     * @return $this
     */
    public function setSelectPriv($select_priv)
    {
        $this->select_priv = $select_priv;

        return $this;
    }

    /**
     * Method to set the value of field insert_priv
     *
     * @param string $insert_priv
     * @return $this
     */
    public function setInsertPriv($insert_priv)
    {
        $this->insert_priv = $insert_priv;

        return $this;
    }

    /**
     * Method to set the value of field update_priv
     *
     * @param string $update_priv
     * @return $this
     */
    public function setUpdatePriv($update_priv)
    {
        $this->update_priv = $update_priv;

        return $this;
    }

    /**
     * Method to set the value of field delete_priv
     *
     * @param string $delete_priv
     * @return $this
     */
    public function setDeletePriv($delete_priv)
    {
        $this->delete_priv = $delete_priv;

        return $this;
    }

    /**
     * Method to set the value of field create_priv
     *
     * @param string $create_priv
     * @return $this
     */
    public function setCreatePriv($create_priv)
    {
        $this->create_priv = $create_priv;

        return $this;
    }

    /**
     * Method to set the value of field drop_priv
     *
     * @param string $drop_priv
     * @return $this
     */
    public function setDropPriv($drop_priv)
    {
        $this->drop_priv = $drop_priv;

        return $this;
    }

    /**
     * Method to set the value of field grant_priv
     *
     * @param string $grant_priv
     * @return $this
     */
    public function setGrantPriv($grant_priv)
    {
        $this->grant_priv = $grant_priv;

        return $this;
    }

    /**
     * Method to set the value of field references_priv
     *
     * @param string $references_priv
     * @return $this
     */
    public function setReferencesPriv($references_priv)
    {
        $this->references_priv = $references_priv;

        return $this;
    }

    /**
     * Method to set the value of field index_priv
     *
     * @param string $index_priv
     * @return $this
     */
    public function setIndexPriv($index_priv)
    {
        $this->index_priv = $index_priv;

        return $this;
    }

    /**
     * Method to set the value of field alter_priv
     *
     * @param string $alter_priv
     * @return $this
     */
    public function setAlterPriv($alter_priv)
    {
        $this->alter_priv = $alter_priv;

        return $this;
    }

    /**
     * Method to set the value of field create_tmp_table_priv
     *
     * @param string $create_tmp_table_priv
     * @return $this
     */
    public function setCreateTmpTablePriv($create_tmp_table_priv)
    {
        $this->create_tmp_table_priv = $create_tmp_table_priv;

        return $this;
    }

    /**
     * Method to set the value of field lock_tables_priv
     *
     * @param string $lock_tables_priv
     * @return $this
     */
    public function setLockTablesPriv($lock_tables_priv)
    {
        $this->lock_tables_priv = $lock_tables_priv;

        return $this;
    }

    /**
     * Method to set the value of field create_view_priv
     *
     * @param string $create_view_priv
     * @return $this
     */
    public function setCreateViewPriv($create_view_priv)
    {
        $this->create_view_priv = $create_view_priv;

        return $this;
    }

    /**
     * Method to set the value of field show_view_priv
     *
     * @param string $show_view_priv
     * @return $this
     */
    public function setShowViewPriv($show_view_priv)
    {
        $this->show_view_priv = $show_view_priv;

        return $this;
    }

    /**
     * Method to set the value of field create_routine_priv
     *
     * @param string $create_routine_priv
     * @return $this
     */
    public function setCreateRoutinePriv($create_routine_priv)
    {
        $this->create_routine_priv = $create_routine_priv;

        return $this;
    }

    /**
     * Method to set the value of field alter_routine_priv
     *
     * @param string $alter_routine_priv
     * @return $this
     */
    public function setAlterRoutinePriv($alter_routine_priv)
    {
        $this->alter_routine_priv = $alter_routine_priv;

        return $this;
    }

    /**
     * Method to set the value of field execute_priv
     *
     * @param string $execute_priv
     * @return $this
     */
    public function setExecutePriv($execute_priv)
    {
        $this->execute_priv = $execute_priv;

        return $this;
    }

    /**
     * Method to set the value of field event_priv
     *
     * @param string $event_priv
     * @return $this
     */
    public function setEventPriv($event_priv)
    {
        $this->event_priv = $event_priv;

        return $this;
    }

    /**
     * Method to set the value of field trigger_priv
     *
     * @param string $trigger_priv
     * @return $this
     */
    public function setTriggerPriv($trigger_priv)
    {
        $this->trigger_priv = $trigger_priv;

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
     * Returns the value of field select_priv
     *
     * @return string
     */
    public function getSelectPriv()
    {
        return $this->select_priv;
    }

    /**
     * Returns the value of field insert_priv
     *
     * @return string
     */
    public function getInsertPriv()
    {
        return $this->insert_priv;
    }

    /**
     * Returns the value of field update_priv
     *
     * @return string
     */
    public function getUpdatePriv()
    {
        return $this->update_priv;
    }

    /**
     * Returns the value of field delete_priv
     *
     * @return string
     */
    public function getDeletePriv()
    {
        return $this->delete_priv;
    }

    /**
     * Returns the value of field create_priv
     *
     * @return string
     */
    public function getCreatePriv()
    {
        return $this->create_priv;
    }

    /**
     * Returns the value of field drop_priv
     *
     * @return string
     */
    public function getDropPriv()
    {
        return $this->drop_priv;
    }

    /**
     * Returns the value of field grant_priv
     *
     * @return string
     */
    public function getGrantPriv()
    {
        return $this->grant_priv;
    }

    /**
     * Returns the value of field references_priv
     *
     * @return string
     */
    public function getReferencesPriv()
    {
        return $this->references_priv;
    }

    /**
     * Returns the value of field index_priv
     *
     * @return string
     */
    public function getIndexPriv()
    {
        return $this->index_priv;
    }

    /**
     * Returns the value of field alter_priv
     *
     * @return string
     */
    public function getAlterPriv()
    {
        return $this->alter_priv;
    }

    /**
     * Returns the value of field create_tmp_table_priv
     *
     * @return string
     */
    public function getCreateTmpTablePriv()
    {
        return $this->create_tmp_table_priv;
    }

    /**
     * Returns the value of field lock_tables_priv
     *
     * @return string
     */
    public function getLockTablesPriv()
    {
        return $this->lock_tables_priv;
    }

    /**
     * Returns the value of field create_view_priv
     *
     * @return string
     */
    public function getCreateViewPriv()
    {
        return $this->create_view_priv;
    }

    /**
     * Returns the value of field show_view_priv
     *
     * @return string
     */
    public function getShowViewPriv()
    {
        return $this->show_view_priv;
    }

    /**
     * Returns the value of field create_routine_priv
     *
     * @return string
     */
    public function getCreateRoutinePriv()
    {
        return $this->create_routine_priv;
    }

    /**
     * Returns the value of field alter_routine_priv
     *
     * @return string
     */
    public function getAlterRoutinePriv()
    {
        return $this->alter_routine_priv;
    }

    /**
     * Returns the value of field execute_priv
     *
     * @return string
     */
    public function getExecutePriv()
    {
        return $this->execute_priv;
    }

    /**
     * Returns the value of field event_priv
     *
     * @return string
     */
    public function getEventPriv()
    {
        return $this->event_priv;
    }

    /**
     * Returns the value of field trigger_priv
     *
     * @return string
     */
    public function getTriggerPriv()
    {
        return $this->trigger_priv;
    }

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test");
        $this->setSource("db");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Db[]|Db|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Db|\Phalcon\Mvc\Model\ResultInterface
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
        return 'db';
    }

}
