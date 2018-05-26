<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'wordpress/wp_db_handler.php';
    require_once CD_PROJECT_PATH . 'includes/ioc_container.php';


    /**
     * Unit test of the class <see cref="\WPDBHandler" />
     */
    class WPDBHandler extends atoum\test {

        /**
         * Test if the prefix is well construct
         */
        public function testWPDBHandler_get_prefix() {

            require_once CD_PROJECT_PATH . 'config/config_keys.php';
            $wp_prefix = "testWPDBHandler_";
            $prefix = "get_prefix";

            // creation of mock of the \StdClass class
            $wpdbMock = new \mock\StdClass;
            
            $wpdbMock->prefix = $wp_prefix;

            $ioc = new \IocContainer(array( DB_PREFIX => $prefix ));

            $wpDbHandler = new \WPDBHandler($ioc, $wpdbMock);

            $prefixResult = $wpDbHandler->get_prefix();
            
            $this
                ->variable($prefixResult)
                    ->isEqualTo("testWPDBHandler_get_prefix");
        }
    }
}