<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCartItemsTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('cart_items');

        $table->addColumn('cart_id', 'integer', ['signed' => false])
              ->addForeignKey('cart_id', 'carts', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])

              ->addColumn('product_id', 'integer', ['signed' => false])
              ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])

              ->addColumn('quantity', 'integer', ['default' => 1])
              
              ->addTimestamps();

        $table->create();
    }
}