<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'view/irenderer.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'view/iview.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'view/iquery.php';

/**
 * Class that handler all the view associate to the 
 * member managment
 */
final class MemberView implements IView {

    //region fields

    /**
     * IOC container that connect all the element together
     * @var IIocContainer
     */
    private $_ioc_container;

    /**
     * Query handler
     * @var IQuery
     */
    private $_query;

    //endregion

    //region Ctor

    /**
     * Initialize a new instance of the class MemberView
     * 
     * @param IIocContainer $ioc
     *      IOC container that connect all the element together
     */
    public function __construct(IIocContainer $ioc) {
        $this->_ioc_container = $ioc;
        $this->_query = $ioc->get(IQuery::Traits);
    }

    //endregion

    //region Methods

    /**
     * default method called when the user go to the member manager page
     */
    public function index() {

        write_log("Index called");
        require_once CD_PLUGIN_INTERFACES_PATH . 'business/imember_mngt.php';

        /**
         * @var IMemberMngt
         */
        $member_mngt = $this->_ioc_container->get(IMemberMngt::Traits);
        if ($member_mngt == null) {
            $this->init_member_handlers();
            $member_mngt = $this->_ioc_container->get(IMemberMngt::Traits);
        }

        $page_number = $this->_query->get_query_var('page_num', 1);
        $member_search = $this->_query->get_query_var('search', '%');

        $data['members'] = $member_mngt->search($page_number, $member_search);

        /**
         * @var IRenderer
         */
        $renderer = $this->_ioc_container->get(IRenderer::Traits);
        $renderer->render_template(CD_PLUGIN_TEMPLATE_PATH . 'admin/members.tpl.php', $data);
    }

    //region Tools

    /**
     * Configure in the IOContainer all the need dependencies associates to the members
     */
    private function init_member_handlers() {
        require_once CD_PLUGIN_INTERFACES_PATH . 'data_layer/imember_dl.php';
        require_once CD_PLUGIN_DATALAYER_PATH . 'member_dl.php';

        $this->_ioc_container->store(IMemberDL::Traits, new MemberDl($this->_ioc_container));

        require_once CD_PLUGIN_BUSINESS_PATH . 'member_mngt.php';

        $this->_ioc_container->store(IMemberMngt::Traits, new MemberMngt($this->_ioc_container));
    }

    //endregion

    //endregion
}