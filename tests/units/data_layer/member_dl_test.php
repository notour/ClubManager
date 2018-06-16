<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../utest_const.php';

    require_once CD_PLUGIN_INTERFACES_PATH . 'idb_handler.php';
    require_once CD_PLUGIN_INCLUDES_PATH . 'guid_tool.php';
    require_once CD_PLUGIN_INCLUDES_PATH . 'ioc_container.php';

    require_once CD_PLUGIN_DATALAYER_PATH . 'member_dl.php';
    
    use mageekguy\atoum;

    /**
     * Unit Test class for the class <see cref="\MemberDL" />
     */
    class MemberDL extends atoum\test {

        //region Methods

        /**
         * Test to construct a new <see cref="\Member" />
         */
        public function testMemberDL__constuct() {

            $this->mockGenerator->generate('\IDBHandler');

            $dbHandlerMock = new \mock\IDBHandler;
            $ioc = new \IocContainer();
            $ioc->store(\IDBHandler::Traits, $dbHandlerMock);

            $memberDL = new \MemberDL($ioc);

            $this
                ->object($memberDL)
                    ->isNotNull()
                    ->isInstanceOf('\MemberDL');
        }

        /**
         * Test to save a new <see cref="\Member" />
         */
        public function testMemberDL_save_insert() {

            $member = $this->create_member();
            $this->mockGenerator->generate('\IDBHandler');

            $dbHandlerMock = new \mock\IDBHandler;
            $dbHandlerMock->getMockController()->get_by_ids = function($desc, $ids) { return NULL; };

            $ioc = new \IocContainer();
            $ioc->store(\IDBHandler::Traits, $dbHandlerMock);

            $memberDL = new \MemberDL($ioc);

            $this
                ->object($memberDL)
                    ->isNotNull()
                    ->isInstanceOf('\MemberDL');

            $this
                ->assert
                    ->when(function() use($memberDL, $member) {
                        $memberDL->save($member);
                    })

                ->mock($dbHandlerMock)
                    ->call('insert')
                    ->once()
                
                ->mock($dbHandlerMock)
                    ->call('get_by_ids')
                    ->once()

                ->mock($dbHandlerMock)
                    ->call('update')
                    ->never();
        }

        /**
         * Test to save a new <see cref="\Member" />
         */
        public function testMemberDL_save_update() {

            $member = $this->create_member();
            $this->mockGenerator->generate('\IDBHandler');

            $dbHandlerMock = new \mock\IDBHandler;
            $dbHandlerMock->getMockController()->get_by_ids = function($desc, $ids) use($member) { return $member; };

            $ioc = new \IocContainer();
            $ioc->store(\IDBHandler::Traits, $dbHandlerMock);

            $memberDL = new \MemberDL($ioc);


            $this
                ->object($memberDL)
                    ->isNotNull()
                    ->isInstanceOf('\MemberDL');

            $this
                ->assert
                    ->when(function() use($memberDL, $member) {
                        $memberDL->save($member);
                    })

                ->mock($dbHandlerMock)
                    ->call('insert')
                    ->never()
                
                ->mock($dbHandlerMock)
                    ->call('get_by_ids')
                    ->once()

                ->mock($dbHandlerMock)
                    ->call('update')
                    ->once();
        }

        /**
         * Create a valid member class
         */
        private function create_member() : \Member {
            $id = getGUID();
            $first_name = getGUID();
            $last_name = getGUID();
            $gender = \Gender::WOMEN;
            $birth_date = new \DateTime('1989-08-16 13:42:42');
            $birth_place = getGUID();
            $cif_id = getGUID();
            $wp_id = rand();

            $member = new \Member($id, $first_name, $last_name, $birth_date, $birth_place, $gender, $wp_id, $cif_id);

            return $member;
        }

        //endregion Methods
    }
}