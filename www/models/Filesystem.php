<?php

namespace Pawel\Fms;

/**
 * Class Filesystem.
 */
class Filesystem extends \Phalcon\Mvc\Model implements FileSystemInterface
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
    public $rootPath;


    public function createFile(FileInterface $file, FolderInterface $parent)
    {

    }


    public function updateFile(FileInterface $file)
    {
        // TODO: Implement updateFile() method.
    }


    public function renameFile(FileInterface $file, $newName)
    {
        // TODO: Implement renameFile() method.
    }


    public function deleteFile(FileInterface $file)
    {
        // TODO: Implement deleteFile() method.
    }


    public function createRootFolder(FolderInterface $folder)
    {
        // TODO: Implement createRootFolder() method.
    }


    public function createFolder(FolderInterface $folder, FolderInterface $parent)
    {
        // TODO: Implement createFolder() method.
    }


    public function deleteFolder(FolderInterface $folder)
    {
        // TODO: Implement deleteFolder() method.
    }


    public function renameFolder(FolderInterface $folder, $newName)
    {
        // TODO: Implement renameFolder() method.
    }


    public function getFolderCount(FolderInterface $folder)
    {
        // TODO: Implement getFolderCount() method.
    }


    public function getFileCount(FolderInterface $folder)
    {
        // TODO: Implement getFileCount() method.
    }


    public function getDirectorySize(FolderInterface $folder)
    {
        // TODO: Implement getDirectorySize() method.
    }


    public function getFolders(FolderInterface $folder)
    {
        // TODO: Implement getFolders() method.
    }


    public function getFiles(FolderInterface $folder)
    {
        // TODO: Implement getFiles() method.
    }


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->hasMany('id', 'Folders', 'filesystem_id', array('alias' => 'Folders'));

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

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Filesystems[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Filesystems
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
