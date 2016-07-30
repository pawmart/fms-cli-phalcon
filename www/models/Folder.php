<?php

namespace Pawel\Fms;

/**
 * Class Folder.
 */
class Folder extends \Phalcon\Mvc\Model implements FolderInterface
{

    // TODO: Move this constant to abstract model (when we have our own).
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    use RepositoryTrait;

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $path;

    /** @var string */
    public $date_created;

    /** @var integer */
    public $parent_id;

    /** @var integer */
    public $filesystem_id;


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @inheritdoc
     */
    public function getCreatedTime()
    {
        return DateTime::createFromFormat(self::DATE_TIME_FORMAT, $this->date_created);
    }


    /**
     * @inheritdoc
     */
    public function setCreatedTime($created)
    {
        if (!$created instanceof \DateTime) {
            throw new \LogicException('Date added should be DateTime object');
        }

        $this->date_created = $created->format(self::DATE_TIME_FORMAT);
    }


    /**
     * @inheritdoc
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * @inheritdoc
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', File::class, 'folder_id', ['alias' => File::class]);
        $this->hasMany('id', Folder::class, 'parent_id', ['alias' => Folder::class]);
        $this->belongsTo('parent_id', Folder::class, 'id', ['alias' => Folder::class]);
        $this->belongsTo('filesystem_id', Filesystem::class, 'id', ['alias' => Filesystem::class]);

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

}
