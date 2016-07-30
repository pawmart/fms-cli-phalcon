<?php

namespace Pawel\Fms;

/**
 * Class RepositoryTrait.
 */
trait RepositoryTrait
{

    /**
     * Because Phalcon DB is 'silly' and does not actually inform us of any problems!
     *
     * @param null $data
     * @param null $whiteList
     *
     * @return void
     *
     * @throws \Phalcon\Db\Exception
     */
    public function save($data = null, $whiteList = null)
    {
        $savedSuccessfully = parent::save($data, $whiteList);

        if (!$savedSuccessfully) {

            $errorStrings = [];

            foreach ($this->getMessages() as $message) {
                $errorStrings[] = (string)$message;
            }

            throw new \Phalcon\Db\Exception(
                "Sorry, the following problems were generated: \n" . implode("- ", $errorStrings));
        }
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Files
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}