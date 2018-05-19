<?php 

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';
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
     * 
     * @param string $table_name
     *      define the name of the table to instanciate
     * 
     * @param array $table_columns
     *      define the name of the columns into the table
     * 
     * @param array $table_ids
     *      define the ids used in the table to identify a row
     */
    public function __construct(string $table_name, array $table_columns, array $table_ids) {
        
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

    //region Methods

    /**
     * generate en stdclass that map db properties and object properties
     */
    public function map(BaseModel $objInstance) {

        $mapped = new stdclass();

        foreach ($this->_columns as $value) {
            $prop_name = str_replace($this->_table_alias . '_' , '', $value);
            if (isset($objInstance->{$prop_name})) {
                $mapped->{$value} = $objInstance->{$prop_name};
            }
        }
        
        return $mapped;
    }

    //endregion Methods
}