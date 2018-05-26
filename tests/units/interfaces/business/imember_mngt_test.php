<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'interfaces/business/imember_mngt.php';

    /**
     * Unit test on <see cref="\IocContainer" />
     */
    class IMemberMngt extends atoum\test {

        /**
         * Ensure the interface IMemberMngt define a traits
         * This will be used as default key in the IocContainer
         */
        public function testIMemberMngt_Traits() {
            $traits = \IMemberMngt::Traits;

            $this
                ->variable($traits)
                    ->isEqualTo("IMemberMngt");
        }
    }
}