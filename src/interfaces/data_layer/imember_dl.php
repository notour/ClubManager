<?php 

declare(strict_types = 1);

require_once dirname( __FILE__ ) . '/../../clubmanager_const.php';

require_once CD_PLUGIN_MODEL_PATH . 'member.php';

/**
 * Define a class in charge of handling <see cref="Member" /> storage
 */
interface IMemberDL {

    //region Fields

    const Traits = "IMemberDL";

    //endregion Fields

    //region Methods

    /**
     * Save the current <see cref="\Member" />
     */
    public function save(Member $member);

    /**
     * Search into the storage for a specific <see cref="\Member" />(s) and a specific page
     */
    public function search(string $search_pattern, int $page_number = -1, int $number_by_page = -1): array;

    /**
     * Get the specific <see cref="\Member" /> with the id pass in arguments
     */
    public function get_by_id(string $id);

    //endregion Methods

}