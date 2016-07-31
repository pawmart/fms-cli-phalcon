<?php


/**
 * Class MainTask.
 */
class MainTask extends \Phalcon\Cli\Task
{

    /**
     * Experiment env.
     */
    public function mainAction()
    {
        $filesystem = $this->getOrCreateFilesystem(__DIR__ . '/roottest');

        $folder = new \Pawel\Fms\Folder();
        $folder->setName('pawel');
        $folder->setPath($filesystem->rootPath . '/' . $folder->getName());

        $file = new \Pawel\Fms\File();
        $file->setName('test.txt');
        $file->size = 0;

        $rootFolder = $filesystem->createRootFolder(new \Pawel\Fms\Folder());
        $filesystem->createFolder($folder, $rootFolder);

        $filesystem->createFile($file, $folder);
    }


    /**
     * Get filesystem.
     *
     * @return \Pawel\Fms\Filesystem
     */
    protected function getOrCreateFilesystem($path)
    {
        $entity = \Pawel\Fms\Filesystem::findFirst(['rootPath' => $path]);

        if ($entity) {
            return $entity;
        }

        // Nothing found in db, lets create one.
        $filesystem           = new \Pawel\Fms\Filesystem();
        $filesystem->rootPath = $path;
        $filesystem->type = \Pawel\Fms\Filesystem::TYPE_LOCAL;
        $filesystem->save();

        return $filesystem;
    }

}
