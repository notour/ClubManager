<?php

require_once dirname( __FILE__ ) . '/' . '../clubmanager_const.php';

require_once CD_PLUGIN_CONFIG_PATH . 'config_keys.php';

$configs = array();


//region DB

/**
 * Define the prefix for all the tables
 */
$configs[DB_PREFIX] = 'ClubManager';

//endregion DB

if(file_exists(CD_PLUGIN_CONFIG_PATH . 'localconfig.php'))
    include_once CD_PLUGIN_CONFIG_PATH . 'localconfig.php';