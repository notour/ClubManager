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
    //endregion fields

    //region ctor

    /**
     * constructor
     */
    protected function __construct() {
    }

    //endregion ctor

    //region properties

    //endregion properties

    //region methods

    /**
     * 
     */
    protected abstract static function _get_table_descriptor();

    /**
     * select all the elements in the database
     */
    public static function select_all(IIocContainer $ioc) {

        $db_handler = $ioc->get(IDBHandler::Traits);

        $caller_class = get_called_class();
        $desc = $caller_class::_get_table_descriptor();

        //select_all_items($desc, $table_alias, $where)
        $items_row_data = $db_handler->select_query_items($desc, $desc->columns);

        $items = array();
        foreach ($items_row_data as $row) {
            $items[] = new $caller_class($row);
        }

        return $items;
    }

    public static function select_by_id(IIocContainer $ioc, guid $id) {
        throw new Exception('Not implemented : select_by_id ' . self);
    }

    //region tools

    //endregion tools

    //endrgion methods
}