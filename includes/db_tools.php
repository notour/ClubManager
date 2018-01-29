<?php

require_once plugin_dir_path( __FILE__ ) . '../wphoenix_const.php';

require_once CD_PLUGIN_MODEL_PATH . 'member.php';

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
class WPhoenixDBTools
{
    //region Properties

    /**
     * 
     */
    public static function get_prefix() {
        global $wpdb;
        return $wpdb->prefix . 'wphoenix';
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
    public static function install_if_needed($script_dir, $script_version, array $table_list, $force_install = FALSE) {
        global $wpdb;

        $wphoenix_prefix = WPhoenixDBTools::get_prefix(); //$wpdb->prefix . 'wphoenix';
        $charset_collate = $wpdb->get_charset_collate();

        write_log('Prefix ' . $wphoenix_prefix);
        write_log('charset_collate ' . $charset_collate);

        $current_db_version = get_option('WPhoenix_db_version');
        
        if ($force_install == FALSE) {
            $force_install = $script_version > $current_db_version;
            write_log("$script_version > $current_db_version = " . ($force_install ? 'true' : 'FALSE'));
        }

        if ($force_install == FALSE) {
            $tables = $wpdb->get_var("SHOW TABLES LIKE '$wphoenix_prefix%'");

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
                $migration_sql = str_replace('<PREFIX>', $wphoenix_prefix, $migration_sql);
                $migration_sql = str_replace('<CHARSET_COLLATE>', $charset_collate, $migration_sql);
                write_log('Execute migration query : ' . $migration_sql);
                dbDelta($migration_sql);
            }
            else {
                // EXPORT
                // IMPORT
            }

            $install_sql = file_get_contents($install_script_path);
            $install_sql = str_replace('<PREFIX>', $wphoenix_prefix, $install_sql);
            $install_sql = str_replace('<CHARSET_COLLATE>', $charset_collate, $install_sql);
            dbDelta($install_sql);
            write_log('Execute install query : ' . $install_sql);

            add_option('WPhoenix_db_version', $script_version);
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
    public static function select_query_items($desc, $columns, $where = NULL) {
        global $wpdb;

        $prefix = WPhoenixDBTools::get_prefix();
        $table_name = $desc->table_name;
        
        $table_alias = 't';
        if (isset($desc->table_alias) && !empty($desc->table_alias)) {
            $table_alias = $desc->table_alias;
        }

        $ids = WPhoenixDBTools::generate_columns($desc, $columns, $table_alias);
        $query = "SELECT $ids FROM {$prefix}_$table_name as $table_alias";
        if (empty($where) == NULL) {
            $query = $query . ' WHERE ' . $where;
        }
        return $wpdb->get_results($query , OBJECT );
    }

    /**
     * return all the item ids of the table describe in $desc that follow the condition $where
     */
    public static function query_item_ids($desc, $where = NULL) {
        return WPhoenixDBTools::query_items($desc, $desc->ids, $where);
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
    private static function generate_columns($desc, $columns, $table_alias) {
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