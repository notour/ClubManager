<?php
/**
Plugin Name: Club Manager
Plugin URI: https://github.com/notour/ClubManager
Description: This plugin will provide helper to managed a club administration and daily life
Version: 0.1
Author: Mickael Thumerel
Author URI: http://Phoenixhockey.be/
License: GPL2
*/

require_once dirname( __FILE__ ) . '/clubmanager_const.php';

require_once CD_PLUGIN_TOOLS_PATH . 'dev_tool.php';
require_once CD_PLUGIN_INCLUDES_PATH . 'member_mngt.php';
require_once CD_PLUGIN_INCLUDES_PATH . 'ioc_container.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Entry points for the plugin
 */
final class ClubManager
{
    //region Fields

    /**
     * IocContainer
     * @var IocContainer
     */
    private $_ioc_container;

    /**
     * Singleton instance
     * @var ClubManager
     */
    private static $s_instance;

    //endregion

    //region Ctor

    /**
     * Entry point of the plugin used to connect this one will all the wordpress entry points
     */
    private function __construct() {

        $this->setup_ioccontainer();

        register_activation_hook(__FILE__, array('ClubManager', 'activate'));
        register_deactivation_hook( __FILE__, array('ClubManager', 'deactivate'));

        register_uninstall_hook(__FILE__, array('ClubManager', 'uninstall'));

        if (is_plugin_active( 'ClubManager/ClubManager.php')) {
            add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        }
    }

    //endregion

    //region Accessor

    /**
     * Get the singleton instance
     */
    public static function getInstance() {
        return ClubManager::$s_instance;
    }

    //region IOC Accessors

    /**
     * Get the config value as setup in the /config/default.php file
     * 
     * @return value 
     *      return the value setup in the config file associate to the specific key.
     *      NULL if the key doesn't exist
     */
    public static function get_ioc_config(string $config_key) {
        return ClubManager::$s_instance->_ioc_container->get_config($config_key);
    }

    /**
     * Gets the specific instance store by the specific $Key
     * 
     * @param string $key
     *      unique $key used to store and retreive a specific instance
     * 
     * @return object instance
     *      return the specific instance associate to the specific key; if the key doesn't existing return NULL
     */
    public static function get_ioc_value(string $key) {
        return ClubManager::$s_instance->_ioc_container->get($key);
    }

    //endregion

    //endregion

    //region methods

    /**
     * Setup singleton instance
     */
    public static function Build() {
        if (ClubManager::$s_instance == null) {
            ClubManager::$s_instance = new ClubManager();
        }
    }

    /**
     * Declare the administration menu
     */
    public function add_admin_menu() {
        //add_menu_page('page title', 'menu label', 'right_labels', 'key', function, icon(default), order(default));

        add_menu_page('ClubManager Administration', 'ClubManager', 'manage_options', 'ClubManager_admin_menu', array($this, 'admin_main_page'));

        //add_submenu_page('parent_key', 'page title', 'menu label', 'right_labels', 'key', function);
        add_submenu_page('ClubManager_admin_menu', 'ClubManager Admin', 'Global Admin', 'manage_options', 'clubManager_admin_menu', array($this, 'admin_main_page'));
        add_submenu_page('ClubManager_admin_menu', 'ClubManager Members', 'Members', 'manage_options', 'clubManager_admin_members_menu', array($this, 'admin_members_page'));
        add_submenu_page('ClubManager_admin_menu', 'ClubManager Events', 'Events', 'manage_options', 'clubManager_admin_event_menu', array($this, 'admin_event_page'));
        add_submenu_page('ClubManager_admin_menu', 'ClubManager Entities', 'Entities', 'manage_options', 'clubManager_admin_entities_menu', array($this, 'admin_entities_page'));
        add_submenu_page('ClubManager_admin_menu', 'ClubManager Settings', 'Plugin Settings', 'manage_options', 'clubManager_admin_settings_menu', array($this, 'admin_settings_page'));
    }

    /**
     * Setup the current IocContainer
     */
    private function setup_ioccontainer() {
        $this->_ioc_container = new IocContainer();

        require_once CD_PLUGIN_INTERFACES_PATH . "idb_handler.php";
        require_once CD_PLUGIN_INCLUDES_PATH . "wp_db_handler.php";

        global $wpdb;
        
        $this->_ioc_container->store(IDBHandler::Traits, new WPDBHandler($this->_ioc_container, $wpdb));
    }

    //region WP callbacks

    /**
     * call to install triggers and setup connexion with the word press API
     */
    public static function activate() {

        /** Install config and databases if needed */
        ClubManager::install();

        /** Activate connexion with wordpress API */
        write_log('Plugin Activate');
    }

    /**
     * call to install remove connexion with the word press API
     */
    public static function deactivate() {
        write_log('Plugin deactivate');
    }

    /**
     * Called to install the current plugin configuration and databases
     */
    public static function install() {
        write_log('Plugin install');

        require_once CD_PLUGIN_INTERFACES_PATH . "idb_handler.php";

        /**
         * Get the db handler
         * @var IDBHandler
         */
        $db_handler = ClubManager::get_ioc_value(IDBHandler::Traits);

        $db_path = CD_PLUGIN_PATH . 'db/install';
        $db_script_dir = $db_path;
        $db_script_version = '0.0.0';

        $install_versions = scandir($db_path, SCANDIR_SORT_DESCENDING);

        foreach ($install_versions as $version) {
            $db_path_version = $db_path . '/' . $version . '/';
            if (file_exists($db_path_version . DB_CREATE_FILE_NAME)) {
                $db_script_dir = $db_path_version;
                $db_script_version = $version;
                break;
            }
        }

        $db_table_list = array(
            'contact_info',
            Member::TABLE_NAME,
            'referent',
            'member_referents',
            'entity',
            'entity_referents',
            'season',
            'category',
            'category_members'
        );

        $db_handler->install_if_needed($db_script_dir, $db_script_version, $db_table_list);
    }

    /**
     * Called to uninstall the current plugin configuration and databases
     */
    public static function uninstall() {
        write_log('Plugin uninstall');

    }

    //endregion WP callbacks

    //region HTML

    public function admin_members_page() {
        $page_number = get_query_var( 'page_num', 1);
        $member_search = get_query_var( 'search', '%');
        $data['members'] = MemberMngt::load_members($page_number, $member_search);
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/members.tpl.php', []);
    }

    public function admin_main_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/admin.tpl.php', []);
    }

    public function admin_event_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/events.tpl.php', []);
    }

    public function admin_entities_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/entities.tpl.php', []);
    }

    public function admin_settings_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/entities.tpl.php', []);
    }

    //endregion

    //endregion
}

ClubManager::Build();