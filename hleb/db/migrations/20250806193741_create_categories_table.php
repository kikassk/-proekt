<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCategoriesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call \"create()\" or \"update()\" and NOT \"save()\" when working
     * with the Table class.
     */
    public function change(): void
    {
        // Создаем таблицу 'categories'
        $table = $this->table('categories');

        // Добавляем колонки
        $table->addColumn('name', 'string', ['limit' => 255])
              ->addColumn('description', 'text', ['null' => true])
              ->addTimestamps(); // Добавляет created_at и updated_at

        // Применяем создание таблицы
        $table->create();
    }
}