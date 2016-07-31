<?php

namespace Pawel\Fms;

use Pawel\Fms\Adapter\Local;
use Phalcon\Mvc\Model\Exception as ModelException;
use Phalcon\Validation\Validator;
use Phalcon\Validation;


/**
 * Class Filesystem.
 */
class Filesystem extends \Phalcon\Mvc\Model implements FileSystemInterface
{
    // TODO: Move this constant to abstract model (when we have our own).
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    use RepositoryTrait;

    const TYPE_LOCAL = 1;

    /** @var integer */
    public $id;

    /** @var integer */
    public $type;

    /** @var string */
    public $rootPath;

    /** @var  Local */
    private $adapter;


    public function validation()
    {
        $validation = new Validation();

        $validation->add(['rootPath', 'type'], new Validator\Uniqueness([
           'message' => 'Filesystem should have unique rootPath per type',
           'model' => $this
        ]));

        return $this->validate($validation);
    }

    /**
     * This should really be abstracted from here but lets keep it here for now.
     *
     * TODO: This should return AdapterInterface.
     *
     * @return Local
     * @throws ModelException
     */
    public function getAdapter()
    {
        if (null !== $this->adapter) {
            return $this->adapter;
        }

        switch ($this->type) {
            case self::TYPE_LOCAL:
                return new Local($this->rootPath);
            default:
                throw new ModelException('No specified adapter supported');
        }
    }

    public function createFile(FileInterface $file, FolderInterface $parent)
    {
        $data = [
            'folder_id' => $parent->id,
            'name' => $file->getName(),
        ];

        if ($exists = File::findFirst($data)) {
            return $exists;
        }

        $now = new \DateTime();

        $file->setParentFolder($parent);

        $file->setCreatedTime($now);
        $file->setModifiedTime($now);

        $file->save();

        $this->getAdapter()->touchFile($file);
    }


    public function updateFile(FileInterface $file)
    {
        $file->save();

        $this->getAdapter()->touchFile($file);
    }


    public function renameFile(FileInterface $file, $newName)
    {
        $file->name = $newName;
        $file->save();

        $this->getAdapter()->moveFile($file, $newName);
    }


    public function deleteFile(FileInterface $file)
    {
        $file->delete();

        $this->getAdapter()->remove($file);
    }


    public function createRootFolder(FolderInterface $folder)
    {
        $folder->setPath($this->rootPath . '/' . $folder->getName());

        $rootFolder = Folder::findFirst(['path' => $folder->getPath()]);

        if ($rootFolder) {
            return $rootFolder;
        }

        $folder->save();

        $this->getAdapter()->createFolder($folder);
    }


    public function createFolder(FolderInterface $folder, FolderInterface $parent)
    {
        $folder->setPath($parent->getPath() . '/' . $folder->getName());

        // If folder already there don't do anything
        if ($exists = Folder::findFirst(
            [
                'path' => $folder->getPath(),
                'name' => $folder->getName(),
                'filesystem_id' => $folder->filesystem_id,
            ])) {
            return $exists;
        }

        $folder->save();

        $this->getAdapter()->createFolder($folder);
    }


    public function deleteFolder(FolderInterface $folder)
    {
        $folder->delete();

        $this->getAdapter()->deleteFolder($folder);
    }


    public function renameFolder(FolderInterface $folder, $newName)
    {
        $folder->name = $newName;
        $folder->save();

        $this->getAdapter()->moveFolder($folder, $newName);

    }


    public function getFolderCount(FolderInterface $folder)
    {
        return count($this->getFolders($folder));

    }


    public function getFileCount(FolderInterface $folder)
    {
        return count($this->getFiles($folder));
    }


    public function getDirectorySize(FolderInterface $folder)
    {
        return $this->getAdapter()->getFolderSize($folder);
    }


    public function getFolders(FolderInterface $folder)
    {
        return Folder::find(['filesystem_id' => $this->id]);
    }


    public function getFiles(FolderInterface $folder)
    {
        return File::find(['folder_id' => $folder->id]);
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', Folder::class, 'filesystem_id', array('alias' => Folder::class));

        $this->keepSnapshots(true);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'filesystems';
    }


}
