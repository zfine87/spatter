<?php

namespace App\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170228163502 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $users_table = $schema->createTable('users');

        $users_table->addColumn('id', 'integer', ['unsigned' => true, 'autoincrement'=>true]);
        $users_table->addColumn('name', 'string', ['length'=>20, 'notnull' => true, 'unique' => true]);
        $users_table->addColumn('email', 'string', ['length' => 60, 'unique' => true, 'notnull' => true]);
        $users_table->addColumn('password', 'string', ['length' => 255, 'notnull' => true]);
        $users_table->addColumn('remember_token', 'string', ['length' => 255]);
        $users_table->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }
}
