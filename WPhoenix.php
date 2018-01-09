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

class PhoenixPlugin
{
    //region Ctor

    /**
     * Entry point of the plugin used to connect this one will all the wordpress entry points
     */
    public function __construct() {
        register_activation_hook(__FILE__, array('PhoenixPlugin', 'install'));
        register_uninstall_hook(__FILE__, array('PhoenixPlugin', 'uninstall'));
    }

    //endregion

    //region methods

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

    //endregion
}

new PhoenixPlugin();