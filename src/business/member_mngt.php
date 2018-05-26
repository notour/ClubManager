<?php
declare(strict_types=1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_MODEL_PATH . 'member.php';
require_once CD_PLUGIN_MODEL_PATH . "search_result.php";

require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'business/imember_mngt.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'data_layer/imember_dl.php';

/**
 * 
 */
final class MemberMngt implements IMemberMngt {
    
    //region fields

    const PAGE_SIZE = 20;

    /**
     * Data layer instance that manipulate directly the member informations in the storage system
     * @var IMemberDL
     */
    private $_dataLayer;

    //endregion fields

    //region ctor

    function __construct(IIocContainer $ioc) {
        $this->_dataLayer = $ioc->get(IMemberDL::Traits);
    }

    //endregion

    //region methods

    /**
     * Return a list of all the data filter by the page number and the specific search_filter
     * 
     * @param number $page_number 
     *      Define the number of the page to load by default a page contains 20 objects
     * 
     * @param any $search_filter
     *      Define a specific filter on the data object
     * 
     * @return SearchResult[]
*          return an array of LoadResult object that contains only data identification
     */
    final function search(int $page_number, $search_filter) : array {
        return array();
    }

    //endregion methods
}