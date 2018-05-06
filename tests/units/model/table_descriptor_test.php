<?php

namespace tests\units 
{
    require_once dirname(__FILE__) . '/../../utest_const.php';

    require_once CD_PLUGIN_INCLUDES_PATH . 'guid_tool.php';
    require_once CD_PLUGIN_MODEL_PATH . 'table_descriptor.php';
    require_once CD_PLUGIN_MODEL_PATH . 'base_model.php';

    use mageekguy\atoum;

    class nestedTestTableDescriptor extends \BaseModel {

        private static $desc;

        const TABLE_NAME = 'nestedTestTableDescriptor';

        CONST TABLE_TRIGRAM = 'tes';

        public function __construct(string $id) {
            parent::__construct($id);
        }

        /**
         * @return nestedTestTableDescriptor Return the table description
         */
        public final static function get_table_descriptor() {
            $desc = nestedTestTableDescriptor::$desc;
            if (nestedTestTableDescriptor::$desc == NULL) {

                $desc = new TableDescriptor(nestedTestTableDescriptor::TABLE_NAME,
                                                array(  nestedTestTableDescriptor::TABLE_TRIGRAM . '_id',
                                                        nestedTestTableDescriptor::TABLE_TRIGRAM . '_id2',
                                                        nestedTestTableDescriptor::TABLE_TRIGRAM . '_name',
                                                        nestedTestTableDescriptor::TABLE_TRIGRAM . '_field2'),
                                            array(nestedTestTableDescriptor::TABLE_TRIGRAM . '_id', nestedTestTableDescriptor::TABLE_TRIGRAM . '_id2'));

                nestedTestTableDescriptor::$desc = $desc;
            }
            return $desc;
        }
    }

    /**
     * Unit Test class for the class <see cref="\TableDescriptor" />
     */
    class TableDescriptor extends atoum\test {

        //region Methods

        /**
         * Test to simply construct a <see cref="TableDescriptor" />
         */
        public final function testTableDescriptor_construct() {

            $table_name = "test";
            
            $colId = "cor_field";
            $col1 = "cor_field1";
            $col2 = "cor_field2";

            $table_columns = array($colId, $col1, $col2);
            $table_ids = array("cor_field");

            $table = new \TableDescriptor($table_name, $table_columns, $table_ids);

            $this
                ->variable($table->table_name)
                    ->isEqualTo($table_name);

            $this
                ->array($table->columns)
                    ->hasSize(3)
                    ->contains($colId)
                    ->contains($col1)
                    ->contains($col2);

            $this
                ->array($table->ids)
                    ->hasSize(1)
                    ->contains($colId);

            $this
                ->variable($table->table_alias)
                    ->isEqualTo('cor');
        }

        //endregion Methods
    }
}