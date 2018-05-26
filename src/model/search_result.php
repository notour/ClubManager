<?php
declare(strict_types=1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INCLUDES_PATH . "base_class.php";

/**
 * Transport all the needed informations
 * to identify one of the result of a search
 */
final class SearchResult extends BaseClass {

    //region fields

    /**
     * Could be used on view to identify the item
     * @var string
     */
    private $_display_name;

    /**
     * Unique db id
     * @var Guid/string
     */
    private $_id;

    /**
     * Extra information that could be used in view but also to
     * store query informations
     * @var any
     */
    private $_extra_info;

    //endregion

    //region ctor

    /**
     * Initialize a new instance of the class SearchResult that
     * transport all the needed informations to identify one of the result of a search
     * 
     * @param string $displayName
     *      Used on view to identify the item
     * 
     * @param string $id
     *      Unique db id of the item
     * 
     * @param any $extraInfo
     *      Extra information that could be used in view but also to
     *      store query informations
     */
    public function __construct(string $display_name, string $id, $extra_info = null) {
        $this->_display_name = $display_name;
        $this->_id = $id;
        $this->_extra_info = $extra_info;
    }

    //endregion

    //region Properties

    /**
     * Gets the result display name
     */
    public function get_display_name() {
        return $this->_display_name;
    }

    /**
     * Gets the result item id
     */
    public function get_id() {
        return $this->_id;
    }

    /**
     * Gets the extra informations associate to the current item
     */
    public function get_extra_info() {
        return $this->_extra_info;
    }

    //endregion
}