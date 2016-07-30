<?php

namespace Pawel\Fms;

/**
 * Class File.
 */
class File extends \Phalcon\Mvc\Model implements FileInterface
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
     * @var integer
     */
    public $size;

    /**
     *
     * @var string
     */
    public $date_created;

    /**
     *
     * @var string
     */
    public $date_modified;

    /**
     *
     * @var integer
     */
    public $folder_id;


    public function getName()
    {
        // TODO: Implement getName() method.
    }


    public function setName($name)
    {
        // TODO: Implement setName() method.
    }


    public function getSize()
    {
        // TODO: Implement getSize() method.
    }


    public function setSize($size)
    {
        // TODO: Implement setSize() method.
    }


    public function getCreatedTime()
    {
        // TODO: Implement getCreatedTime() method.
    }


    public function setCreatedTime($created)
    {
        // TODO: Implement setCreatedTime() method.
    }


    public function getModifiedTime()
    {
        // TODO: Implement getModifiedTime() method.
    }


    public function setModifiedTime($modified)
    {
        // TODO: Implement setModifiedTime() method.
    }


    public function getParentFolder()
    {
        // TODO: Implement getParentFolder() method.
    }


    public function setParentFolder(FolderInterface $parent)
    {
        // TODO: Implement setParentFolder() method.
    }


    public function getPath()
    {
        // TODO: Implement getPath() method.
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('folder_id', 'Folders', 'id', array('alias' => 'Folders'));

        $this->keepSnapshots(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'files';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
