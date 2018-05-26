<?php
declare(strict_types=1);

namespace tests\units 
{
    require_once dirname(__FILE__) . '/../../utest_const.php';
    require_once CD_PROJECT_PATH . '/model/search_result.php';

    require_once CD_PLUGIN_INCLUDES_PATH . 'guid_tool.php';

    use mageekguy\atoum;

    /**
     * Unit Test class for the class <see cref="\SearchResult" />
     */
    class SearchResult extends atoum\test {

        //region Methods

        /**
         * Test to construct <see cref="\SearchResult" />
         */
        public function testSearchResult_construct_property_getter() {

            $id = getGUID();
            $display_name = getGUID();
            $extra_info = array();

            $search_result = new \SearchResult($display_name, $id, $extra_info);

            $this
                ->variable($search_result)
                    ->isNotNull();
            $this
                ->variable($search_result->id)
                    ->isEqualTo($id);

            $this
                ->variable($search_result->display_name)
                    ->isEqualTo($display_name);

            $this
                ->variable($search_result->extra_info)
                    ->isEqualTo($extra_info);
        }

        //endregion Methods
    }
}