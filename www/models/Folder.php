<?php

namespace Pawel\Fms;

use Phalcon\Validation\Validator;
use Phalcon\Validation;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Class Folder.
 */
class Folder extends \Phalcon\Mvc\Model implements FolderInterface
{

    // TODO: Move this constant to abstract model (when we have our own).
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s.z';

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


    public function validation()
    {
        $validation = new Validation();

        $validation->add(['name', 'parent_id', 'filesystem_id'], new Validator\Uniqueness([
           'message' => 'Folder should have unique name and parent directory',
           'model' => $this
        ]));

        return $this->validate($validation);
    }

    public function beforeCreate(){
        $this->date_created = date(self::DATE_TIME_FORMAT);
    }


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
        // TODO: This should not be needed, handled by initialise.
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

        $this->addBehavior(new Timestampable(array(
            'beforeValidationOnCreate' => array(
                'field' => 'date_created',
                'format' => self::DATE_TIME_FORMAT
            )
        )));
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
