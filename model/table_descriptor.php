<?php 

require_once plugin_dir_path( __FILE__ ) . '../wphoenix_const.php';
require_once CD_PLUGIN_INCLUDES_PATH . 'base_class.php';

/**
 * Contains all the table data needed to automitize queries
 */
final class TableDescriptor extends BaseClass {

    //region fields

    private $_table_name;
    private $_table_alias;
    private $_columns;
    private $_ids;

    //endregion fields

    //region ctor

    /**
     * Initialize the table descriptor
     */
    public function __construct($table_name, array $table_columns, array $table_ids) {
        
        if (count($table_ids) == 0 ){
            throw new Exception("$table_name : zero id defined");
        }

        if (count($table_columns) == 0 ){
            throw new Exception("$table_name : zero columns defined");
        }
        foreach ($table_ids as $id) {
            if (!in_array($id, $table_columns)) {
                throw new Exception("$table_name : $id'id doesn't exist in the column definition");
            }
        }

        $this->_table_name = $table_name;
        $this->_columns = $table_columns;
        $this->_ids = $table_ids;

        $first_id = $this->ids[0];
        $first_id_parts = explode('_', $first_id);

        if (count($first_id_parts) < 2) {
            throw new Exception("$table_name : $first_id id and columns must be format following the trigram rules : 'TRI_column_name' where TRI is unique by table");
        }

        $this->_table_alias = $first_id_parts[0];
    }

    //endregion ctor

    //region properties

    /**
     * Get table name
     */
    public function get_table_name() {
        return $this->_table_name;
    }

    /**
     * Get the trigram the could be use as alias of the table
     */
    public function get_table_alias() {
        return $this->_table_alias;
    }

    /**
     * Get column's names
     */
    public function get_columns() {
        return $this->_columns;
    }

    /**
     * Get values corresponding to id column names
     */
    public function get_ids() {
        return $this->_ids;
    }

    //endregion

}