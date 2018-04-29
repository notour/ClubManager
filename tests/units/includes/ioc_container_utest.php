<?php

namespace tests\units;

require_once dirname(__FILE__) . '/../../utest_const.php';

use mageekguy\atoum;

/**
 * Class tested
 */
require_once CD_PROJECT_PATH . 'includes/ioc_container.class.php';

/**
 * Unit test on <see cref="\IocContainer" />
 */
class IocContainer extends atoum\test {
    
    /**
     * Test to simple create a new instance of the <see cref="IocContainer" />
     */
    public function testIocContainer_Create() {
        $ioc = new \IocContainer();

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
    public function testIocContainer_Create_Multiple() {
        $ioc = new \IocContainer();
        $ioc2 = new \IocContainer();
        $ioc3 = new \IocContainer();

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

    /**
     * Test if we can retreive data from the config
     */
    public function testIocContainer_getConfig() {
        $key = 'TEST_KEY';
        $val = \rand(0, 4242);

        $config = array( $key  => $val );

        $ioc = new \IocContainer($config);

        $result = $ioc->get_config($key);

        $this
            ->integer($result)
                ->isEqualTo($val);

        do
        {
            $newValue = \rand(0, 4242);
        } while($newValue == $result);

        $config[$key] = $newValue;
        $newResult = $ioc->get_config($key);

        $this
            ->integer($newResult)
                ->isEqualTo($val);

        $this
            ->integer($newResult)
                ->isNotEqualTo($newValue);
    }

    /**
     * Test if we can retreive data from the config
     */
    public function testIocContainer_getConfig_unknown_key() {
        $val = "key" . \rand(0, 4242);
        $ioc = new \IocContainer();

        $result = $ioc->get_config($val);

        $this
            ->variable($result)
                ->isNull($result);
    }
}