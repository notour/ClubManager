<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'idb_handler.php';

require_once CD_PLUGIN_INCLUDES_PATH . 'base_class.php';

require_once CD_PLUGIN_MODEL_PATH . 'table_descriptor.php';

/**
 * Base class of all the db classes
 */
abstract class BaseModel extends BaseClass {

    //region fields

    private $_id;

    //endregion fields

    //region ctor

    /**
     * constructor
     */
    protected function __construct(string $id) {
        $this->_id = $id;
    }

    //endregion ctor

    //region properties

    /**
     * Gets the member unique id
     */
    public function get_id(): string {
        return $this->_id;
    }

    //endregion properties

    //region methods

    /**
     * 
     */
    public abstract static function get_table_descriptor();

    //endrgion methods
}