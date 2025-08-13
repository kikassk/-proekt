<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsersTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('users');

        $table->addColumn('telegram_id', 'biginteger', ['signed' => false])
              ->addColumn('is_bot', 'boolean', ['default' => false])
              ->addColumn('first_name', 'string', ['limit' => 255])
              ->addColumn('last_name', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('username', 'string', ['limit' => 255, 'null' => true])
              ->addColumn('language_code', 'string', ['limit' => 10, 'null' => true])
              ->addTimestamps()
              ->addIndex(['telegram_id'], ['unique' => true])
              ->create();
    }
}