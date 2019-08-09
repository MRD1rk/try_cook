<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcRecipeIngredientMigration_113
 */
class TcRecipeIngredientMigration_113 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_recipe_ingredient', [
                'columns' => [
                    new Column(
                        'id_recipe',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'id_ingredient',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_recipe'
                        ]
                    ),
                    new Column(
                        'id_recipe_part',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_ingredient'
                        ]
                    ),
                    new Column(
                        'value',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 50,
                            'after' => 'id_recipe_part'
                        ]
                    ),
                    new Column(
                        'unit',
                        [
                            'type' => Column::TYPE_CHAR,
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'value'
                        ]
                    ),
                    new Column(
                        'position',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'default' => "0",
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'unit'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_recipe', 'id_ingredient'], 'PRIMARY'),
                    new Index('FK_tc_recipe_ingredient_tc_ingredients', ['id_ingredient'], null)
                ],
                'references' => [
                    new Reference(
                        'FK_tc_recipe_ingredient_tc_ingredients',
                        [
                            'referencedTable' => 'tc_ingredients',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_ingredient'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'FK_tc_recipe_ingredient_tc_recipes',
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
