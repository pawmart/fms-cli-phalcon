<?php

namespace Pawel\Fms\Adapter;

use Pawel\Fms\FileInterface;
use Pawel\Fms\FolderInterface;

/**
 * Class Local adapter.
 *
 * This adapter deals with local file system.
 */
class Local
{

    protected $rootPath;


    /**
     * Local constructor.
     *
     * @param $rootPath
     */
    public function __construct($rootPath)
    {
        if (is_link(($rootPath))) {
            $rootPath = realpath($rootPath);
        }

        if (!is_dir($rootPath)) {
            mkdir($rootPath);
        }
    }


    /**
     * Create root folder.
     *
     * @param $path
     */
    public function createRootFolder($path)
    {
        // No action needed for this adapter.
    }


    public function createFolder(FolderInterface $folder)
    {
        $path = $folder->getPath();

        if (!is_dir($path)) {
            mkdir($path);
        }
    }


    public function deleteFolder(FolderInterface $folder)
    {
        $this->deleteTree($folder->getPath());
    }


    public function touchFile(FileInterface $file)
    {
        $path = $file->getParentFolder()->getPath() . '/' . $file->getName();
        touch($path);
    }


    public function moveFile(FileInterface $file, $newName)
    {
        $oldPath = $file->getPath() . '/' . $file->getName();
        $newPath = $file->getPath() . '/' . $newName;

        rename($oldPath, $newPath);
    }


    public function moveFolder(FolderInterface $folder, $newName)
    {
        $oldPath = $folder->getPath();
        $newPath = dirname($folder->getPath()) . '/' . $newName;

        rename($oldPath, $newPath);
    }


    public function remove($file)
    {
        unlink($file->getPath() . '/' . $file->getName());
    }


    public function getFolderSize(FolderInterface $folder)
    {
        return dirsize($folder->getPath());
    }


    private function deleteTree($dir)
    {
        $files = array_diff(scandir($dir), ['.', '..']);

        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }

        return rmdir($dir);
    }


    private function dirSize($dir)
    {
        if ($dh = opendir($dir)) {
            $size = 0;

            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                $data = $this->dirsize($dir . '/' . $file);
                $size += $data['size'];
            }

            closedir($dh);

            return $size;
        }

        return 0;
    }

}