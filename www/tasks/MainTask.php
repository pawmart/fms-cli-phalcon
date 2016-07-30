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
        $filesystem = $this->getOrCreateFilesystem( __DIR__ . '/roottest');

        // TODO: Do something with filesystem.


    }


    /**
     * Get filesystem.
     *
     * @return \Pawel\Fms\Filesystem
     */
    protected function getOrCreateFilesystem($path)
    {
        $filesystem = new \Pawel\Fms\Filesystem();

        $entity = $filesystem->findFirst(['rootPath' => $path]);

        if ($entity) {
            return $entity;
        }

        // Nothing found in db, lets create new one.
        $filesystem           = new \Pawel\Fms\Filesystem();
        $filesystem->rootPath = $path;
        // TODO: inject type of the adapter this will be using.
        $filesystem->save();

        return $filesystem;
    }

}
