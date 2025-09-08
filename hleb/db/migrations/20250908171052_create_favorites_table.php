<?php
declare(strict_types=1);
use Phinx\Migration\AbstractMigration;
final class CreateFavoritesTable extends AbstractMigration
{
public function change(): void
{
$table = $this->table('favorites');
$table->addColumn('user_id', 'integer', ['signed' => false])
->addColumn('product_id', 'integer', ['signed' => false])
->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
->addIndex(['user_id', 'product_id'], ['unique' => true])
->create();
}
}