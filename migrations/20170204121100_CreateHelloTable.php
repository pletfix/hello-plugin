<?php

use Core\Services\Contracts\Database;
use Core\Services\Contracts\Migration as MigrationContract;

class CreateTestTable implements MigrationContract
{
    /**
     * @inheritdoc
     */
    public function up(Database $db)
    {
        $db->schema()->createTable('hello', [
            'id'   => ['type' => 'identity'],
            'name' => ['type' => 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down(Database $db)
    {
        $db->schema()->dropTable('hello');
    }
}