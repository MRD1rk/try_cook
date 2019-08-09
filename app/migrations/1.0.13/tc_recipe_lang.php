<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcRecipeLangMigration_113
 */
class TcRecipeLangMigration_113 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_recipe_lang', [
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
                        'id_lang',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_recipe'
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
                        'description',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 500,
                            'after' => 'title'
                        ]
                    ),
                    new Column(
                        'content',
                        [
                            'type' => Column::TYPE_TEXT,
                            'notNull' => true,
                            'after' => 'description'
                        ]
                    ),
                    new Column(
                        'link_rewrite',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 255,
                            'after' => 'content'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_recipe', 'id_lang'], 'PRIMARY'),
                    new Index('FK_tc_recipe_lang_tc_langs', ['id_lang'], null)
                ],
                'references' => [
                    new Reference(
                        'FK_tc_recipe_lang_tc_langs',
                        [
                            'referencedTable' => 'tc_langs',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_lang'],
                            'referencedColumns' => ['id'],
                            'onUpdate' => 'RESTRICT',
                            'onDelete' => 'RESTRICT'
                        ]
                    ),
                    new Reference(
                        'FK_tc_recipe_lang_tc_recipes',
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
