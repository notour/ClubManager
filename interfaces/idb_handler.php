<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_MODEL_PATH . 'table_descriptor.php';

interface IDBHandler
{
    const Traits = "IDBHandler";

    //region Methods

    /**
     * Provide the plugin databases prefix
     */
    public function get_prefix();

    /**
     * check db version and table on databases to determine if the db is correctly setup if not use the latest script to migrate
     * or install the tables.
     * 
     * @param string $script_dir 
     *      Directory where the scripts could be found. Must end by '/'
     * 
     * @param string $script_version
     *      Version in format 'MAJOR.MINOR.RELEASE' of the script that will be used if needed (ex: 1.0.0) 
     * 
     * @param array $table_list
     *      List of the tables that must be found on wordpress for the plugin tyo work correctly
     * 
     * @param bool $force_install
     *      True, if you want to skip the checks and directly install the scripts; default value FALSE
     * 
     * @return bool
     *      True if the tables have been installed; otherwise FALSE
     */
    public function install_if_needed($script_dir, $script_version, array $table_list, $force_install = FALSE);

    /**
     * Apply a simple select query on one table
     * 
     * @param TableDescriptor $desc
     *      descriptor of the target table
     */
    public function select_query_items(TableDescriptor $desc, $columns, $where = NULL);

    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     * 
     *  @param TableDescriptor $desc
     *      descriptor of the target table
     */
    public function query_item_ids(TableDescriptor $desc, $where = NULL);

    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     * 
     *  @param TableDescriptor $desc
     *      descriptor of the target table
     * 
     * @param stdclass $ids
     *      define all the ids values
     */
    public function get_by_ids(TableDescriptor $desc, stdclass $ids);

    /**
     * Insert a new item describe by the table description and the values pass in arguments
     * 
     * @param TableDescriptor $desc
     *      descriptor of the target table
     * 
     * @param stdclass $values
     *      define the values to insert
     *  
     */
    public function insert(TableDescriptor $desc, stdclass $values);

    /**
     * Update the item describe by the table description and the values pass in arguments
     * 
     * @param TableDescriptor $desc
     *      descriptor of the target table
     * 
     * @param stdclass $values
     *      define the values to insert
     * 
     * @param stdclass $ids
     *      define the ids of the object to update 
     */
    public function update(TableDescriptor $desc, stdclass $values, stdclass $ids = null);

    //endregion
}