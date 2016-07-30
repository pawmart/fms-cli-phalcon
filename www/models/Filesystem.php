<?php

namespace Pawel\Fms;

use Pawel\Fms\Adapter\Local;
use Phalcon\Mvc\Model\Exception as ModelException;

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


    /**
     * This method upsets me. Should we really allow root folder creation?
     *
     * API could be a bit cleaner without it i think.
     *
     * @param FolderInterface $folder
     *
     * @return Files
     */
    public function createRootFolder(FolderInterface $folder)
    {
        // TODO: Lets discard whatever has been passed to us ;/
        $rootFolder = Folder::findFirst(['name' => '.']);

        if ($rootFolder) {
            return $rootFolder;
        }

        $folder->setPath($this->rootPath);
        $folder->setName('.');

        $dateTime = new \DateTime();
        $folder->setCreatedTime($dateTime);

        $folder->save();

        $this->getAdapter()->createRootFolder($this->rootPath);

        return $folder;
    }


    public function createFolder(FolderInterface $folder, FolderInterface $parent)
    {
        $folder->save();

        $this->getAdapter()->createFolder($folder);

        return $folder;
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
