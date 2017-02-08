<?php

use Core\Services\Contracts\Migration as MigrationContract;
use Core\Services\PDOs\Schemas\Contracts\Schema;

/**
 * Migration Class
 */
class CreateHelloTable implements MigrationContract
{
    /**
     * @inheritdoc
     */
    public function up(Schema $schema)
    {
        $schema->createTable('hello', [
            'id'   => ['type' => 'identity'],
            'name' => ['type' => 'string'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('hello');
    }
}