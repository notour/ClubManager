<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'interfaces/iioc_container.php';

    /**
     * Unit test on <see cref="\IocContainer" />
     */
    class IIocContainer extends atoum\test {

        /**
         * Ensure the interface IIocContainer define a traits
         * This will be used as default key in the IocContainer
         */
        public function testIIocContainer_Traits() {
            $traits = \IIocContainer::Traits;

            $this
                ->variable($traits)
                    ->isEqualTo("IIocContainer");
        }
    }
}