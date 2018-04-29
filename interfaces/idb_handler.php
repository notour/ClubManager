<?php

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
     */
    public function select_query_items($desc, $columns, $where = NULL);

    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     */
    public function query_item_ids($desc, $where = NULL);

    //endregion
}