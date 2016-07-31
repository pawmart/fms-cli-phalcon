<?php

namespace Pawel\Fms;

/**
 * Class FilesystemManager.
 */
class FilesystemManager
{

    public static function getOrCreateFilesystem($path)
    {
        $entity = \Pawel\Fms\Filesystem::findFirst(['rootPath' => $path]);

        if ($entity) {
            return $entity;
        }

        // Nothing found in db, lets create one.
        $filesystem           = new \Pawel\Fms\Filesystem();
        $filesystem->rootPath = $path;
        $filesystem->type     = \Pawel\Fms\Filesystem::TYPE_LOCAL;
        $filesystem->save();

        return $filesystem;
    }


    public static function createFolder(FileSystemInterface $filesystem, $folderString)
    {
        if (!strpos($folderString, '/')) {

            $folder = new \Pawel\Fms\Folder();
            $folder->setName($folderString);

            $filesystem->createRootFolder($folder);
        } else {
            $parentPath = dirname($filesystem->rootPath . '/' . $folderString);

            $parentFolder = \Pawel\Fms\Folder::findFirst(['path' => $parentPath]);

            if (!$parentFolder) {
                echo 'Failure!';
                echo 'Folder could not be created. Are you sure base directories are created already?';
                exit;
            }

            $folder = new \Pawel\Fms\Folder();
            $folder->setName(basename($filesystem->rootPath . '/' . $folderString));

            $filesystem->createFolder($folder, $parentFolder);
        }
    }


    public static function createFile(FileSystemInterface $filesystem, $folderString, $fileString)
    {
        $parentPath = dirname($filesystem->rootPath . '/' . $folderString);

        $parentFolder = \Pawel\Fms\Folder::findFirst(['path' => $parentPath]);

        if (!$parentFolder) {
            echo 'Failure!';
            echo 'Folder could not be found. Are you sure folder is created already?';
            exit;
        }

        $file = new \Pawel\Fms\File();
        $file->setName($fileString);
        $file->setSize(0);

        $filesystem->createFile($file, $parentFolder);
    }
}