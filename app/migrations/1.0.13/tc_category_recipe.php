<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcCategoryRecipeMigration_113
 */
class TcCategoryRecipeMigration_113 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_category_recipe', [
                'columns' => [
                    new Column(
                        'id_category',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'id_recipe',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_category'
                        ]
                    ),
                    new Column(
                        'position',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_recipe'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_category', 'id_recipe'], 'PRIMARY'),
                    new Index('FK_tc_recipe_category_tc_recipes', ['id_recipe'], null)
                ],
                'references' => [
                    new Reference(
                        'FK_tc_recipe_category_tc_categories',
                        [
                            'referencedTable' => 'tc_categories',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_category'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'FK_tc_recipe_category_tc_recipes',
                        [
                            'referencedTable' => 'tc_recipes',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_recipe'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    )
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
