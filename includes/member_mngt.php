<?php

require_once plugin_dir_path( __FILE__ ) . '..//wphoenix_const.php';
require_once CD_PLUGIN_MODEL_PATH . 'member.php';

/**
 * 
 */
final class MemberMngt {
    
    //region fields

    const PAGE_SIZE = 20;

    //endregion fields

    //region methods

    static final function load_members($page_number, $member_search) {
        return Member::select_all();
    }

    //endregion methods
}