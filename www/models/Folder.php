<?php

namespace Pawel\Fms;

/**
 * Class Folder.
 */
class Folder extends \Phalcon\Mvc\Model implements FolderInterface
{
    use RepositoryTrait;

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $path;

    /**
     *
     * @var string
     */
    public $date_created;

    /**
     *
     * @var integer
     */
    public $parent_id;

    /**
     *
     * @var integer
     */
    public $filesystem_id;


    public function getName()
    {
        // TODO: Implement getName() method.
    }


    public function setName($name)
    {
        // TODO: Implement setName() method.
    }


    public function getCreatedTime()
    {
        // TODO: Implement getCreatedTime() method.
    }


    public function setCreatedTime($created)
    {
        // TODO: Implement setCreatedTime() method.
    }


    public function getPath()
    {
        // TODO: Implement getPath() method.
    }


    public function setPath($path)
    {
        // TODO: Implement setPath() method.
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Files', 'folder_id', array('alias' => 'Files'));
        $this->hasMany('id', 'Folders', 'parent_id', array('alias' => 'Folders'));
        $this->belongsTo('parent_id', 'Folders', 'id', array('alias' => 'Folders'));
        $this->belongsTo('filesystem_id', 'Filesystems', 'id', array('alias' => 'Filesystems'));

        $this->keepSnapshots(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'folders';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Folders[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Folders
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
