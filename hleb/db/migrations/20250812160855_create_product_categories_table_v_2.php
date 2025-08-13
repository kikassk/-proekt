<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductCategoriesTableV2 extends AbstractMigration
{
    public function change(): void
    {
       
        $table = $this->table('product_categories', ['id' => false, 'primary_key' => ['product_id', 'category_id']]);

        $table->addColumn('product_id', 'integer', ['signed' => false, 'null' => false])
              ->addColumn('category_id', 'integer', ['signed' => false, 'null' => false])
              ->addForeignKey('product_id', 'products', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->addForeignKey('category_id', 'categories', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
              ->create();
    }
}
