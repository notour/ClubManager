<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'interfaces/data_layer/imember_dl.php';

    class IMemberDL  extends atoum\test
    {
        /**
         * Test the insterface define correctly a traits
         */
        public function testIMemberDL_Traits()
        {
            $traits = \IMemberDL::Traits;

            $this
                ->variable($traits)
                    ->isEqualTo("IMemberDL");
        }
    }
}