<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'idb_handler.php';
require_once CD_PLUGIN_MODEL_PATH . 'member.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';

define('DB_CREATE_FILE_NAME', 'create_db.sql');
define('DB_MIGRATE_FILE_NAME', 'migration_from_<VERSION>.sql');

// define('DB_TABLE_LIST', array(
//     'contact_info',
//     Member::TABLE_NAME,
//     'referent',
//     'member_referents',
//     'entity',
//     'entity_referents',
//     'season',
//     'category',
//     'category_members'
// ));

/**
 * static class that host tools around db manipulation
 */
class WPDBHandler implements IDBHandler
{
    //region Fields

    private $_wpdb;
    private $_ioc_container;
    private $_configured_prefix;

    //endregion Fields

    //region Ctor

    /**
     * Initialize a new instance of the class <see cref="CMDBTools" />
     */
    public function __construct(IIocContainer $container, $wpdbInst) {
        require_once CD_PLUGIN_CONFIG_PATH . 'config_keys.php';
        
        $this->_wpdb = $wpdbInst;
        $this->_ioc_container = $container;
        $this->_configured_prefix = $container->get_config(DB_PREFIX);
    }

    //endregion Ctor

    //region Properties

    /**
     * Gets the prefix of all the db tables
     */
    public function get_prefix() {
        return $this->_wpdb->prefix . $this->_configured_prefix;
    }

    //endregion Properties

    //region Methods

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
    public function install_if_needed($script_dir, $script_version, array $table_list, $force_install = FALSE) {

        $db_prefix = $this->get_prefix();
        $charset_collate = $this->_wpdb->get_charset_collate();

        write_log('Prefix ' . $db_prefix);
        write_log('charset_collate ' . $charset_collate);

        $current_db_version = get_option('WPhoenix_db_version');
        
        if ($force_install == FALSE) {
            $force_install = $script_version > $current_db_version;
            write_log("$script_version > $current_db_version = " . ($force_install ? 'true' : 'FALSE'));
        }

        if ($force_install == FALSE) {
            $tables = $this->_wpdb->get_var("SHOW TABLES LIKE '$db_prefix%'");

            if (count($tables) == count($table_list)) {
                foreach($table_list as $table_name) {
                    if (!isset($tables)) {
                        $force_install = TRUE;
                        break;
                    }
                }
                if ($force_install == FALSE) {
                    write_log('All tables already exists');
                }
            }
            else {
                $force_install = TRUE;
            }
        }
        
        if ($force_install == TRUE) {
            /* install */
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

            $install_script_path = $script_dir . DB_CREATE_FILE_NAME;
            if (!file_exists($install_script_path)) {
                throw new Exception("Install db file missing $install_script_path");
            }

            $migration_script_path = $script_dir . str_replace('<VERSION>', $current_db_version, DB_MIGRATE_FILE_NAME); //'migration_from_' . $current_db_version . '.sql';
            if (file_exists($migration_script_path)) {
                $migration_sql = file_get_contents($migration_script_path);
                $migration_sql = str_replace('<PREFIX>', $db_prefix, $migration_sql);
                $migration_sql = str_replace('<CHARSET_COLLATE>', $charset_collate, $migration_sql);
                write_log('Execute migration query : ' . $migration_sql);
                dbDelta($migration_sql);
            }
            else {
                // EXPORT
                // IMPORT
            }

            $install_sql = file_get_contents($install_script_path);
            $install_sql = str_replace('<PREFIX>', $db_prefix, $install_sql);
            $install_sql = str_replace('<CHARSET_COLLATE>', $charset_collate, $install_sql);
            dbDelta($install_sql);
            write_log('Execute install query : ' . $install_sql);

            add_option('ClubManager_db_version', $script_version);
            return TRUE;
        }
        else {
            write_log('No need to setup db');
        }
        return FALSE;
    }

    /**
     * Apply a simple select query on one table 
     */
    public function select_query_items(TableDescriptor $desc, $columns, $where = NULL) {
        $prefix = $this->get_prefix();
        $table_name = $desc->table_name;
        
        $table_alias = 't';
        if (isset($desc->table_alias) && !empty($desc->table_alias)) {
            $table_alias = $desc->table_alias;
        }

        $ids = CMDBTools::generate_columns($desc, $columns, $table_alias);
        $query = "SELECT $ids FROM {$prefix}_$table_name as $table_alias";
        if (empty($where) == NULL) {
            $query = $query . ' WHERE ' . $where;
        }
        return $this->_wpdb->get_results($query , OBJECT );
    }

    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     */
    public function query_item_ids(TableDescriptor $desc, $where = NULL) {
        return $this->query_items($desc, $desc->ids, $where);
    }
    
    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     * 
     *  @param TableDescriptor $desc
     *      descriptor of the target table
     * 
     * @param stdclass $ids
     *      define all the ids values
     */
    public function get_by_ids(TableDescriptor $desc, stdclass $ids) {
        throw new Exception("Not implemented");
    }

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
    public function insert(TableDescriptor $desc, stdclass $values) {
        throw new Exception("Not implemented");
    }

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
    public function update(TableDescriptor $desc, stdclass $values, stdclass $ids = null) {
        throw new Exception("Not implemented");
    }

    //region tools

    /**
     * Concate all the id keys provide by the description
     * 
     * @param class $desc
     *      db table descriptions
     * 
     * @return string concatenation of the ids example : 'cli_id, cli_id2'
     */
    private static function generate_columns(TableDescriptor $desc, $columns, $table_alias) {
        $cols = '';
        $first = true;
        foreach ($columns as $col_name) {
            if ($first == FALSE) {
                $cols = $cols . ', ';
            }

            $cols = $cols . $table_alias . '.' . $col_name;
            $first = FALSE;
        }
        return $cols;
    }

    //endregion tools

    //endregion Methods    
}