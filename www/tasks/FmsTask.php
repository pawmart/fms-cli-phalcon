<?php


/**
 * Class File Management System operations.
 */
class FmsTask extends \Phalcon\Cli\Task
{

    const BASEDIR = __DIR__ . '/../filesystem';


    /**
     * Filesystem operations.
     */
    public function filesystemAction()
    {
        $baseDir = self::BASEDIR;

        if (!is_dir($baseDir)) {
            exec('mkdir ' . $baseDir);
        }

        $this->getOrCreateFilesystem(realpath(self::BASEDIR));

        echo 'Success!';
    }


    /**
     * Folder operations.
     *
     * @param array $params
     */
    public function folderAction(array $params)
    {
        $filesystem = $this->getOrCreateFilesystem(realpath(self::BASEDIR));

        switch (trim($params[0])) {
            case 'create':

                if (!isset($params[1])) {
                    echo 'Please provide folder name as parameter';
                    exit;
                }

                if (substr($params[1], 0, 1) === '/') {
                    echo 'Folder name can not start with slash';
                    exit;
                }

                $folderString = trim($params[1], '/');

                // TODO: Inject this as a service via DI.
                \Pawel\Fms\FilesystemManager::createFolder($filesystem, $folderString);

                echo 'Success!';

                break;

            default:
                throw new ErrorException('Action not supported');
        }
    }


    /**
     * File operations.
     *
     * @param array $params
     */
    public function fileAction(array $params)
    {
        $filesystem = $this->getOrCreateFilesystem(realpath(self::BASEDIR));

        switch (trim($params[0])) {
            case 'create':

                if (!isset($params[1])) {
                    echo 'Please provide file name as parameter';
                    exit;
                }

                if (substr($params[1], 0, 1) === '/') {
                    echo 'File name can not start with slash';
                    exit;
                }

                $fileString = trim($params[1], '/');

                if (strpos($fileString, '/')) {
                    echo 'File name can not contain slashes';
                    exit;
                }

                if (!isset($params[2])) {
                    echo 'Please provide folder name as second parameter';
                    exit;
                }

                if (substr($params[2], 0, 1) === '/') {
                    echo 'Folder name can not start with slash';
                    exit;
                }

                $folderString = trim($params[2], '/');

                \Pawel\Fms\FilesystemManager::createFile($filesystem, $folderString, $fileString);

                echo 'Success!';

                break;

            default:
                throw new ErrorException('Action not supported');
        }
    }


    /**
     * Get filesystem.
     *
     * @return \Pawel\Fms\Filesystem
     */
    protected function getOrCreateFilesystem($path)
    {
        return \Pawel\Fms\FilesystemManager::getOrCreateFilesystem($path);
    }

}
