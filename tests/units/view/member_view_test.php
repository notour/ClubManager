<?php
declare(strict_types=1);

namespace tests\units 
{
    require_once dirname(__FILE__) . '/../../utest_const.php';

    require_once CD_PROJECT_PATH . '/view/member_view.php';
    require_once CD_PROJECT_PATH . '/includes/ioc_container.php';

    use mageekguy\atoum;

    /**
     * Unit Test class for the class <see cref="\MemberView" />
     */
    class MemberView extends atoum\test {

        /**
         * Test to simply create a MemberView
         */
        public function testMemberView_ctor() {
            $view = new \MemberView(new \IocContainer());

            $this
                ->variable($view)
                    ->isNotNull();
        }

        /**
         * Test to call the index method
         */
        public function testMemberView_index() {

            require_once CD_PROJECT_PATH . 'interfaces/view/irenderer.php';
            require_once CD_PROJECT_PATH . 'interfaces/view/iquery.php';
            require_once CD_PROJECT_PATH . 'interfaces/business/imember_mngt.php';
            require_once CD_PROJECT_PATH . 'model/search_result.php';

            $ioc = new \IocContainer();

            $this->mockGenerator->generate('\IQuery');
            $iquery = new \mock\IQuery;
            $iquery->getMockController()->get_query_var = function(string $query_key, $default_value) { return $default_value; };

            $ioc->store(\IQuery::Traits, $iquery);

            $this->mockGenerator->generate('\IRenderer');
            $irenderer = new \mock\IRenderer;

            $ioc->store(\IRenderer::Traits, $irenderer);

            $memberResult = array();
            array_push($memberResult, new \SearchResult("Test", "testId") );
            $this->mockGenerator->generate('\IMemberMngt');
            $imemberMngt = new \mock\IMemberMngt;
            $imemberMngt->getMockController()->search = function(int $page_number, $search_filter) use($memberResult) { return $memberResult; };

            $ioc->store(\IMemberMngt::Traits, $imemberMngt);

            $view = new \MemberView($ioc);

            $view->index();

            $this
                ->variable($view)
                    ->isNotNull();

            $this
                ->mock($iquery)
                    ->call('get_query_var')
                        ->withArguments('page_num', 1)->once()
                        ->withArguments('search', '%')->once();

            $this
                ->mock($irenderer)
                    ->call('render_template')
                        ->withArguments(CD_PLUGIN_TEMPLATE_PATH . 'admin/members.tpl.php', array('members' => $memberResult)) ->once();

            $this
                ->mock($imemberMngt)
                    ->call('search')
                        ->withArguments(1, '%')->once();
        }
    }
}