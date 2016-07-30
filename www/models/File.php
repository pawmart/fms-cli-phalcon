<?php

namespace Pawel\Fms;

/**
 * Class File.
 */
class File extends \Phalcon\Mvc\Model implements FileInterface
{

    // TODO: Move this constant to abstract model (when we have our own).
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    use RepositoryTrait;

    /** @var integer */
    public $id;

    /** @var string */
    public $name;

    /** @var integer */
    public $size;

    /** @var string */
    public $date_created;

    /** @var string */
    public $date_modified;

    /** @var integer */
    public $folder_id;


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
    public function getSize()
    {
        return $this->size;
    }


    /**
     * @inheritdoc
     */
    public function setSize($size)
    {
        $this->size = $size;

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
    public function getModifiedTime()
    {
        return DateTime::createFromFormat(self::DATE_TIME_FORMAT, $this->date_created);
    }


    /**
     * @inheritdoc
     */
    public function setModifiedTime($modified)
    {
        if (!$modified instanceof \DateTime) {
            throw new \LogicException('Date modified should be DateTime object');
        }

        $this->date_modified = $modified->format(self::DATE_TIME_FORMAT);
    }


    /**
     * @inheritdoc
     */
    public function getParentFolder()
    {
        // TODO: There must the another way to do this (this sucks).
        return Folder::findFirst(['id' => $this->folder_id]);
    }


    /**
     * @inheritdoc
     */
    public function setParentFolder(FolderInterface $parent)
    {
        $this->folder_id = $parent->id;
    }


    /**
     * @inheritdoc
     */
    public function getPath()
    {
        return $this->getParentFolder()->getPath();
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->belongsTo('folder_id', Folder::class, 'id', ['alias' => Folder::class]);

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

}
