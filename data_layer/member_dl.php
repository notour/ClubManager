<?php

declare(strict_types = 1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_DATALAYER_PATH . 'base_dl.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'imember_dl.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'idb_handler.php';

/**
 * Data Layer in change of managing storage of member and it's related informations
 */
final class MemberDL extends BaseDL implements IMemberDL {

    //region Fields
    //endregion Fields

    //region CTOR

    /**
     * Initialize a new instance of the class <see cref="MemberDL" />
     */
    public  final function __construct(IDBHandler $db_handler) {
        parent::__construct($db_handler);
    }

    //endregion CTOR

    //region Properties
    //endregion Properties

    //region Methods

    /**
     * Save the current <see cref="\Member" />
     */
    public final function save(Member $member) {
        $desc = Member::get_table_descriptor();
        parent::onSave($desc, $member);
    }

    /**
     * Search into the storage for a specific <see cref="\Member" />(s) and a specific page
     */
    public final function search(string $search_pattern, int $page_number = -1, int $number_by_page = -1): array {
        throw new Exception("Not Implemented");
    }

    /**
     * Get the specific <see cref="\Member" /> with the id pass in arguments
     */
    public final function get_by_id(string $id) {
        throw new Exception("Not Implemented");
    }

    //endregion Methods
}