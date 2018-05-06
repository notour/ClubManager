<?php

declare(strict_types=1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_MODEL_PATH . 'base_model.php';
require_once CD_PLUGIN_MODEL_PATH . 'table_descriptor.php';

require_once CD_PLUGIN_ENUM_PATH . 'gender_enum.php';

/**
 * Member class model
 */
final class Member extends BaseModel {

    //region fields

    private static $desc;

    const TABLE_NAME = 'member';

    const TABLE_TRIGRAM = 'mem';

    private $_wp_id;
    private $_first_name;
    private $_last_name;
    private $_birth_date;
    private $_birth_place;
    private $_gender;
    private $_cif_id;
    private $_create;

    //endregion fields

    //region Ctor

    /**
     * Initialize a new instance of the class <see cref="\Member" />
     */
    public function __construct(string $id,
                                string $first_name,
                                string $last_name,
                                DateTime $birth_date,
                                string $birth_place,
                                int $gender,
                                int $wp_id,
                                string $cif_id) {
        
        parent::__construct($id);

        $this->_first_name = $first_name;
        $this->_last_name = $last_name;
        $this->_birth_date = $birth_date;
        $this->_birth_place = $birth_place;
        $this->_gender = $gender;
        $this->_cif_id = $cif_id;
        $this->_wp_id = $wp_id;
    }

    //endregion Ctor

    /**
     * Gets the member first name
     */
    public function get_first_name(): string {
        return $this->_first_name;
    }

    /**
     * Gets the member last name
     */
    public function get_last_name() : string {
        return $this->_last_name;
    }

    /**
     * Gets the member birth date
     */
    public function get_birth_date() : DateTime {
        return $this->_birth_date;
    }

    /**
     * Gets the member birth place
     */
    public function get_birth_place() : string {
        return $this->_birth_place;
    }

    /**
     * Gets the member gender <see cref="Gender" />
     */
    public function get_gender(): int {
        return $this->_gender;
    }

    //region Properties

    //endregion Properties

    //region methods

    /**
     * @return table_descriptor Return the table description
     */
    public final static function get_table_descriptor() {
        $desc = Member::$desc;
        if (Member::$desc == NULL) {

            $desc = new TableDescriptor(Member::TABLE_NAME,
                                        array(Member::TABLE_TRIGRAM . '_id',
                                                Member::TABLE_TRIGRAM . '_create',
                                                Member::TABLE_TRIGRAM . '_first_name',
                                                Member::TABLE_TRIGRAM . '_last_name',
                                                Member::TABLE_TRIGRAM . '_birth_date',
                                                Member::TABLE_TRIGRAM . '_birth_place',
                                                Member::TABLE_TRIGRAM . '_gender',
                                                Member::TABLE_TRIGRAM . '_cif_id',
                                                Member::TABLE_TRIGRAM . '_wp_id'),
                                        array(Member::TABLE_TRIGRAM . '_id'));

            Member::$desc = $desc;
        }
        return $desc;
    }

    //endregion methods
}