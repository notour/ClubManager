<?php

require_once dirname( __FILE__ ) . '/../../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . "idata_mngt_base.php";

/**
 * Define an interface in charge of handler all the 
 * manipulation on a user
 */
interface IMemberMngt extends IDataMngtBase {

    const Traits  = "IMemberMngt";

    //region methods
    //endregion
}