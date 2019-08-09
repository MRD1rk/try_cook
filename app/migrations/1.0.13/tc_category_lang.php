<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcCategoryLangMigration_113
 */
class TcCategoryLangMigration_113 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_category_lang', [
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
                        'id_lang',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id_category'
                        ]
                    ),
                    new Column(
                        'name',
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
                            'type' => Column::TYPE_TEXT,
                            'after' => 'name'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_category', 'id_lang'], 'PRIMARY'),
                    new Index('id_lang', ['id_lang'], null)
                ],
                'references' => [
                    new Reference(
                        'FK_tc_category_lang_tc_categories',
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
                        'FK_tc_category_lang_tc_langs',
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
