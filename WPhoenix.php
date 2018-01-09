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

define( 'CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'CD_PLUGIN_TEMPLATE_PATH', plugin_dir_path( __FILE__ ) . '/templates/' ) ;
define( 'CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once CD_PLUGIN_PATH . 'dev_tool.php';

class PhoenixPlugin
{
    //region Ctor

    /**
     * Entry point of the plugin used to connect this one will all the wordpress entry points
     */
    public function __construct() {
        register_activation_hook(__FILE__, array('PhoenixPlugin', 'install'));
        register_uninstall_hook(__FILE__, array('PhoenixPlugin', 'uninstall'));

        add_action('admin_menu', array($this, 'add_admin_menu'), 20);
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
        add_submenu_page('phoenix_admin_menu', 'Phoenix Events', 'Events', 'manage_options', 'phoenix_admin_event_menu', array($this, 'admin_event_page'));
        add_submenu_page('phoenix_admin_menu', 'Phoenix Entities', 'Entities', 'manage_options', 'phoenix_admin_entities_menu', array($this, 'admin_entities_page'));
    }

    /**
     * Called to install the current plugin configuration and databases
     */
    public static function install() {

    }

    /**
     * Called to uninstall the current plugin configuration and databases
     */
    public static function uninstall() {

    }

    //region HTML

    public function admin_main_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/admin.tpl.php', []);
    }

    public function admin_event_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/events.tpl.php', []);
    }

    public function admin_entities_page() {
        echo render_template(CD_PLUGIN_TEMPLATE_PATH . '/admin/entities.tpl.php', []);
    }

    //endregion

    //endregion
}

new PhoenixPlugin();