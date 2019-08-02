<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class TcTranslateLangMigration_108
 */
class TcTranslateLangMigration_108 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('tc_translate_lang', [
                'columns' => [
                    new Column(
                        'id_translate',
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
                            'after' => 'id_translate'
                        ]
                    ),
                    new Column(
                        'value',
                        [
                            'type' => Column::TYPE_VARCHAR,
                            'notNull' => true,
                            'size' => 2000,
                            'after' => 'id_lang'
                        ]
                    ),
                    new Column(
                        'date_add',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'value'
                        ]
                    ),
                    new Column(
                        'date_upd',
                        [
                            'type' => Column::TYPE_TIMESTAMP,
                            'default' => "CURRENT_TIMESTAMP",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'date_add'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id_translate', 'id_lang'], 'PRIMARY'),
                    new Index('FK_tc_translate_lang_tc_langs', ['id_lang'], null)
                ],
                'references' => [
                    new Reference(
                        'FK_tc_translate_lang_tc_langs',
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
                        'FK_tc_translate_lang_tc_translates',
                        [
                            'referencedTable' => 'tc_translates',
                            'referencedSchema' => 'try_cook_db',
                            'columns' => ['id_translate'],
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
