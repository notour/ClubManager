<?php
/*
Plugin Name: Phoenix Administration
Plugin URI: http://phoenixhockey.be/
Description: This plugin will provide helper to managed the phoenix administration and daily life
Version: 0.1
Author: Mickael Thumerel
Author URI: http://phoenixhockey.be/
License: GPL2
*/

require_once plugin_dir_path( __FILE__ ) . 'wphoenix_const.php';

require_once CD_PLUGIN_TOOLS_PATH . 'dev_tool.php';
require_once CD_PLUGIN_INCLUDES_PATH . 'member_mngt.php';

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

final class PhoenixPlugin
{
    //region Ctor

    /**
     * Entry point of the plugin used to connect this one will all the wordpress entry points
     */
    public function __construct() {
        register_activation_hook(__FILE__, array('PhoenixPlugin', 'activate'));
        register_deactivation_hook( __FILE__, array('PhoenixPlugin', 'deactivate'));

        register_uninstall_hook(__FILE__, array('PhoenixPlugin', 'uninstall'));

        if (is_plugin_active( 'WPhoenix/WPhoenix.php')) {
            add_action('admin_menu', array($this, 'add_admin_menu'), 20);
        }
    }

    //endregion

    //region methods

    /**
     * Declare the administration menu
     */
    public function add_admin_menu() {
        //add_menu_page('page title', 'menu label', 'right_labels', 'key', function, icon(default), order(default));

        add_menu_page('Phoenix Administration', 'Phoenix', 'manage_options', 'phoenix_admin_menu', array($this, 'admin_main_page'));

        //add_submenu_page('parent_key', 'page title', 'menu label', 'right_labels', 'key', function);
        add_submenu_page('phoenix_admin_menu', 'Phoenix Admin', 'Global Admin', 'manage_options', 'phoenix_admin_menu', array($this, 'admin_main_page'));
        add_submenu_page('phoenix_admin_menu', 'Phoenix Members', 'Members', 'manage_options', 'phoenix_admin_members_menu', array($this, 'admin_members_page'));
        add_submenu_page('phoenix_admin_menu', 'Phoenix Events', 'Events', 'manage_options', 'phoenix_admin_event_menu', array($this, 'admin_event_page'));
        add_submenu_page('phoenix_admin_menu', 'Phoenix Entities', 'Entities', 'manage_options', 'phoenix_admin_entities_menu', array($this, 'admin_entities_page'));
        add_submenu_page('phoenix_admin_menu', 'Phoenix Settings', 'Plugin Settings', 'manage_options', 'phoenix_admin_settings_menu', array($this, 'admin_settings_page'));
    }

    /**
     * call to install triggers and setup connexion with the word press API
     */
    public static function activate() {

        /** Install config and databases if needed */
        PhoenixPlugin::install();

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

        require_once CD_PLUGIN_PATH . '/includes/db_tools.php';

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

        WPhoenixDBTools::install_if_needed($db_script_dir, $db_script_version, $db_table_list);
    }

    /**
     * Called to uninstall the current plugin configuration and databases
     */
    public static function uninstall() {
        write_log('Plugin uninstall');

    }

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

new PhoenixPlugin();