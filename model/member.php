<?php

require_once plugin_dir_path( __FILE__ ) . '../wphoenix_const.php';
require_once CD_PLUGIN_MODEL_PATH . 'base_model.php';
require_once CD_PLUGIN_MODEL_PATH . 'table_descriptor.php';

/**
 * Member class model
 */
final class Member extends BaseModel{

    //region fields

    private static $desc;

    const TABLE_NAME = 'member';

    //endregion fields

    //region methods

    /**
     * @return table_descriptor Return the table description
     */
    protected final static function _get_table_descriptor() {
        $desc = Member::$desc;
        if (Member::$desc == NULL) {

            $desc = new TableDescriptor(Member::TABLE_NAME,
                                        array('mem_id',
                                              'mem_create',
                                              'mem_first_name',
                                              'mem_last_name',
                                              'mem_birth_date',
                                              'mem_birth_place',
                                              'mem_gender',
                                              'mem_cif_id',
                                              'mem_wp_id'),
                                        array('mem_id'));

            Member::$desc = $desc;
        }
        return $desc;
    }

    //endregion methods
}