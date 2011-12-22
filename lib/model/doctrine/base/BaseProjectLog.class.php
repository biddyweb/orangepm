<?php

/**
 * BaseProjectLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $projectId
 * @property integer $addedBy
 * @property clob $description
 * @property date $loggedDate
 * @property Project $Project
 * @property User $User
 * 
 * @method integer    getId()          Returns the current record's "id" value
 * @method integer    getProjectId()   Returns the current record's "projectId" value
 * @method integer    getAddedBy()     Returns the current record's "addedBy" value
 * @method clob       getDescription() Returns the current record's "description" value
 * @method date       getLoggedDate()  Returns the current record's "loggedDate" value
 * @method Project    getProject()     Returns the current record's "Project" value
 * @method User       getUser()        Returns the current record's "User" value
 * @method ProjectLog setId()          Sets the current record's "id" value
 * @method ProjectLog setProjectId()   Sets the current record's "projectId" value
 * @method ProjectLog setAddedBy()     Sets the current record's "addedBy" value
 * @method ProjectLog setDescription() Sets the current record's "description" value
 * @method ProjectLog setLoggedDate()  Sets the current record's "loggedDate" value
 * @method ProjectLog setProject()     Sets the current record's "Project" value
 * @method ProjectLog setUser()        Sets the current record's "User" value
 * 
 * @package    orangepm
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseProjectLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('orangepm_project_log');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('project_id as projectId', 'integer', 20, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => 20,
             ));
        $this->hasColumn('added_by as addedBy', 'integer', 20, array(
             'type' => 'integer',
             'length' => 20,
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('logged_date as loggedDate', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Project', array(
             'local' => 'project_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('User', array(
             'local' => 'added_by',
             'foreign' => 'id',
             'onDelete' => 'set null'));
    }
}