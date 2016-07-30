<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;

/**
 * Class DbTask.
 *
 * Task responsible for creating initial schema for the project.
 */
class DbTask extends \Phalcon\Cli\Task
{

    /**
     * Run forest, run!
     *
     * @return void
     */
    public function mainAction()
    {
        echo "Creating db schema for the project\n";

        $this->db->begin();

        try {
            $this->createTables();
        } catch (\Exception $e) {
            $this->db->rollback();

            throw $e;
        }

        $this->db->commit();
        echo 'Success!';
    }


    /**
     * Create tables needed for filesystem management.
     *
     * @return void
     */
    protected function createTables()
    {
        /**
         * TODO: Few things to highlight here.
         *
         * - Filesystem should have its type based on adapter (the concept we don't have yet)
         * - rootPath should be probably unique at least for 'local' adapter
         * - some sort of slug or name would be useful if we are going to expand on it
         */

        $this->db->createTable(
            "filesystems",
            null,
            [
                "columns" => [
                    new Column("id",
                        [
                            "type"          => Column::TYPE_INTEGER,
                            "size"          => 10,
                            "notNull"       => true,
                            "autoIncrement" => true,
                        ]
                    ),
                    new Column("rootPath",
                        [
                            "type"    => Column::TYPE_VARCHAR,
                            "notNull" => true,
                        ]
                    ),
                    new Column("type",
                        [
                            "type"    => Column::TYPE_INTEGER,
                            "notNull" => true,
                        ]
                    ),
                ],
                "indexes" => [
                    new Index(
                        "PRIMARY",
                        ["id"]
                    ),
                ],
            ]
        );

        /**
         * TODO: Few things to highlight here.
         *
         * - add unique index for path and name.
         * - date_created should strictly be always auto-populated
         * - indexing additions
         * - add proper cascade behaviour
         */
        $this->db->createTable(
            "folders",
            null,
            [
                "columns"    => [
                    new Column("id",
                        [
                            "type"          => Column::TYPE_INTEGER,
                            "size"          => 10,
                            "notNull"       => true,
                            "autoIncrement" => true,
                        ]
                    ),
                    new Column("name",
                        [
                            "type"    => Column::TYPE_VARCHAR,
                            "notNull" => true,
                        ]
                    ),
                    new Column("path",
                        [
                            "type"    => Column::TYPE_VARCHAR,
                            "notNull" => true,
                        ]
                    ),
                    new Column("date_created",
                        [
                            "type"    => Column::TYPE_DATETIME,
                            "notNull" => true,
                        ]
                    ),
                    new Column("parent_id",
                        [
                            "type"    => Column::TYPE_INTEGER,
                            "size"    => 11,
                            "notNull" => false,
                        ]
                    ),
                    new Column("filesystem_id",
                        [
                            "type"    => Column::TYPE_INTEGER,
                            "size"    => 11,
                            "notNull" => false,
                        ]
                    ),
                ],
                "indexes"    => [
                    new Index(
                        "PRIMARY",
                        ["id"]
                    ),
                ],
                "references" => [
                    new \Phalcon\Db\Reference('fk_folders_filesystem',
                        [
                            'referencedSchema'  => null,
                            'referencedTable'   => "filesystems",
                            'columns'           => ["filesystem_id"],
                            'referencedColumns' => ["id"],
                        ]
                    ),
                    new \Phalcon\Db\Reference('fk_folders_folder',
                        [
                            'referencedSchema'  => null,
                            'referencedTable'   => "folders",
                            'columns'           => ["parent_id"],
                            'referencedColumns' => ["id"],
                        ]
                    ),
                ],
            ]
        );

        /**
         * TODO: Few things to highlight here.
         *
         * - add unique name of the file per folder
         * - date_created should strictly be always auto-populated
         * - indexing additions
         */
        $this->db->createTable(
            "files",
            null,
            [
                "columns"    => [
                    new Column("id",
                        [
                            "type"          => Column::TYPE_INTEGER,
                            "size"          => 10,
                            "notNull"       => true,
                            "autoIncrement" => true,
                        ]
                    ),
                    new Column("name",
                        [
                            "type"    => Column::TYPE_VARCHAR,
                            "size"    => 70,
                            "notNull" => true,
                        ]
                    ),
                    new Column("size",
                        [
                            "type"    => Column::TYPE_INTEGER,
                            "size"    => 11,
                            "notNull" => true,
                        ]
                    ),
                    new Column("date_created",
                        [
                            "type"    => Column::TYPE_DATETIME,
                            "notNull" => true,
                        ]
                    ),
                    new Column("date_modified",
                        [
                            "type"    => Column::TYPE_DATETIME,
                            "notNull" => true,
                        ]
                    ),
                    new Column("folder_id",
                        [
                            "type"    => Column::TYPE_INTEGER,
                            "size"    => 11,
                            "notNull" => false,
                        ]
                    ),
                ],
                "indexes"    => [
                    new Index(
                        "PRIMARY",
                        ["id"]
                    ),
                ],
                "references" => [
                    new \Phalcon\Db\Reference('fk_files_folder',
                        [
                            'referencedSchema'  => null,
                            'referencedTable'   => "folders",
                            'columns'           => ["folder_id"],
                            'referencedColumns' => ["id"],
                        ]
                    ),
                ],
            ]
        );
    }

}
