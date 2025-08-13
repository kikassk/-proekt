<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCartsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('carts');

        $table->addColumn('user_id', 'integer', ['signed' => false])
              ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->addTimestamps();

        $table->create();
    }
}