<?php

namespace tests\units\TestItems {
    class EmptyTestClass {

    }
}

namespace tests\units 
{

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
    
        //region Create

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

        //endregion Create


        //region getConfig

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

        //endregion getConfig

        //region store

        /**
         * Test to simply store an instance
         */
        public function testIocContainer_store() {

            $unique_key = "IocContainer";
            $ioc = new \IocContainer();

            $newInstance = new \tests\units\TestItems\EmptyTestClass();

            $result = $ioc->store($unique_key, $newInstance);

            $this
                ->variable($result)
                    ->isEqualTo(TRUE);
        }

        /**
         * Test to store an instance with the same key
         */
        public function testIocContainer_store_twice() {

            $unique_key = "IocContainer";
            $ioc = new \IocContainer();

            $newInstance = new \tests\units\TestItems\EmptyTestClass();

            $result = $ioc->store($unique_key, $newInstance);

            $this
                ->variable($result)
                    ->isEqualTo(TRUE);

            $newResult = $ioc->store($unique_key, $newInstance);

            $this
                ->variable($newResult)
                    ->isEqualTo(FALSE);
        }

        /**
         * Test to store an instance with the key NULL
         */
        public function testIocContainer_store_null_key() {

            $ioc = new \IocContainer();

            $newInstance = new \tests\units\TestItems\EmptyTestClass();

            $result = $ioc->store((string)null, $newInstance);

            $this
                ->variable($result)
                    ->isEqualTo(FALSE);
        }

        /**
         * Test to store a null instance
         */
        public function testIocContainer_store_null_instance() {

            $unique_key = "IocContainer";
            $ioc = new \IocContainer();

            $newInstance = new \tests\units\TestItems\EmptyTestClass();

            $result = $ioc->store($unique_key, null);

            $this
                ->variable($result)
                    ->isEqualTo(FALSE);
        }

        //endregion store

        //region Get

        /**
         * Test to get the instance after storage
         */
        public function testIocContainer_get() {

            $unique_key = "IocContainer";
            $ioc = new \IocContainer();

            $newInstance = new \tests\units\TestItems\EmptyTestClass();

            $result = $ioc->store($unique_key, $newInstance);

            $getInst = $ioc->get($unique_key);

            $this->variable($getInst)->isNotNull();

            $this
                ->object($getInst)
                    ->isInstanceOf('\tests\units\TestItems\EmptyTestClass')
                    ->isIdenticalTo($newInstance);
        }

        /**
         * Test to get the instance with a bad key
         */
        public function testIocContainer_get_with_bad_key() {

            $unique_key = "IocContainer";
            $ioc = new \IocContainer();

            $getInst = $ioc->get($unique_key);

            $this->variable($getInst)->isNull();
        }

        //endregion Get
    }
}