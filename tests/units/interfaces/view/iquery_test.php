<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'interfaces/view/iquery.php';

    class IQuery extends atoum\test
    {
        /**
         * Test the insterface define correctly a traits
         */
        public function testIQuery_Traits()
        {
            $traits = \IQuery::Traits;

            $this
                ->variable($traits)
                    ->isEqualTo("IQuery");
        }
    }
}