<?php

namespace tests\units;

require_once dirname(__FILE__) . '/../../utest_const.php';

use mageekguy\atoum;

/**
 * Class tested
 */
require_once CD_PROJECT_PATH . 'classes/ioc_container.class.php';


class IocContainer extends atoum\test {
    
    /**
     * Test to simple create a new instance of the <see cref="IocContainer" />
     */
    public function IocContainer_Create() {
        $ioc = new IocContainer();

        $this
            ->class('\IocContainer')
                ->hasInterface('\IIocContainer');

        $this
            ->variable($ioc)
                ->isNotNull();
    }

        /**
     * Test to simple create a new instance of the <see cref="IocContainer" />
     */
    public function IocContainer_Create_Multiple() {
        $ioc = new IocContainer();
        $ioc2 = new IocContainer();
        $ioc3 = new IocContainer();

        $this
            ->variable($ioc)
                ->isNotNull();

        $this
            ->variable($ioc2)
                ->isNotNull();

        $this
            ->variable($ioc3)
                ->isNotNull();
    }
}