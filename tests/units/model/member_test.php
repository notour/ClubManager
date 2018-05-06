<?php

namespace tests\units 
{
    require_once dirname(__FILE__) . '/../../utest_const.php';
    require_once dirname(__FILE__) . '/../../../model/member.php';

    require_once CD_PLUGIN_INCLUDES_PATH . 'guid_tool.php';

    use mageekguy\atoum;

    /**
     * Unit Test class for the class <see cref="\Member" />
     */
    class Member extends atoum\test {

        //region Methods

        /**
         * Test to construct <see cref="\Member" />
         */
        public function testMember_construct_property_getter() {

            $id = getGUID();
            $first_name = getGUID();
            $last_name = getGUID();
            $gender = \Gender::WOMEN;
            $birth_date = new \DateTime('1989-08-16 13:42:42');
            $birth_place = getGUID();
            $cif_id = getGUID();
            $wp_id = rand();

            $member = new \Member($id, $first_name, $last_name, $birth_date, $birth_place, $gender, $wp_id, $cif_id);

            $this
                ->variable($member)
                    ->isNotNull();
            $this
                ->variable($member->id)
                    ->isEqualTo($id);

            $this
                ->variable($member->first_name)
                    ->isEqualTo($first_name);

            $this
                ->variable($member->last_name)
                    ->isEqualTo($last_name);

            $this
                ->datetime($member->birth_date)
                    ->hasYear(1989)
                    ->hasMonth(8)
                    ->hasDay(16)
                    ->hasHours(13)
                    ->hasMinutes(42)
                    ->hasSeconds(42);

            $this
                ->variable($member->birth_place)
                    ->isEqualTo($birth_place);

            $this
                ->variable($member->gender)
                    ->isEqualTo(\Gender::WOMEN);
        }

        //endregion Methods
    }
}