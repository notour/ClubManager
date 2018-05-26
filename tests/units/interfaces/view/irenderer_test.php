<?php

namespace tests\units 
{

    require_once dirname(__FILE__) . '/../../../utest_const.php';

    use mageekguy\atoum;

    /**
     * Class tested
     */
    require_once CD_PROJECT_PATH . 'interfaces/view/irenderer.php';

    class IRenderer extends atoum\test
    {
        /**
         * Test the insterface define correctly a traits
         */
        public function testIRenderer_Traits()
        {
            $traits = \IRenderer::Traits;

            $this
                ->variable($traits)
                    ->isEqualTo("IRenderer");
        }
    }
}