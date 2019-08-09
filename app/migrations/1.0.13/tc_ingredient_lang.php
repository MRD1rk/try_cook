<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcIngredientLangMigration_113
 */
class TcIngredientLangMigration_113 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_ingredient_lang', [
                'columns' => [
                    new Column(
                        'id_ingredient',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'id_lang',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_ingredient'
                        ]
                    ),
                    new Column(
                        'title',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 250,
                            'after' => 'id_lang'
                        ]
                    ),
                    new Column(
                        'content',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => true,
                            'after' => 'title'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_ingredient', 'id_lang'], 'PRIMARY'),
                    new Index('FK__tc_langs', ['id_lang'], null)
                ],
                'references' => [
                    new Reference(
                        'FK__tc_ingredients',
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
                        'FK__tc_langs',
                        [
                            'referencedTable' => 'tc_langs',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_lang'],
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
