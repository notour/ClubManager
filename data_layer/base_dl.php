<?php

declare(strict_types = 1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';
require_once CD_PLUGIN_INTERFACES_PATH . 'idb_handler.php';


/**
 * base class for al the data layers
 */
abstract class BaseDL {
    
    //region Fields

    private $_db_handler;

    //endregion

    //region CTOR

    /**
     * instanciate a new instance of the class <see cref="BaseDL" />
     */
    protected function __construct(IDBHandler $db_handler) {

        if (!isset($db_handler))
            throw new InvalidArgumentException(ErrorMessages::null_argument("db_handler"));

        $this->_db_handler = $db_handler;
    }

    //endregion

    //region Methods

    /**
     * save the current instance
     */
    protected final function onSave(TableDescriptor $desc, BaseModel $inst) {
        $values = $desc->map($inst);

        $ids = new stdclass();

        foreach ($desc->ids as $value) {
            if (isset($values->{$value})) {
                $ids->{$value} = $values->{$value};
            }
        }

        $exist = $this->_db_handler->get_by_ids($desc, $ids);

        if ($exist == NULL) {
            $this->_db_handler->insert($desc, $values);
        }
        else {
            $this->_db_handler->update($desc, $values, $ids);
        }
    }

    //endregion
}