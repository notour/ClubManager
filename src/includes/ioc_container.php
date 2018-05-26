<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';
include_once CD_PLUGIN_CONFIG_PATH . 'default.php';

/**
 * Default IOC container
 */
final class IocContainer implements IIocContainer
{
    //region Fields

    private $_instances;
    private $_local_config;

    //endregion Fields

    //region Ctor

    /**
     * Initialize a new instance of the class <see cref="IocContainer" />
     * Load data from the /config/default.php
     * 
     * @param assoc_array $extra_custom_config
     *      Extra configuration add un dynamic. This array is also used for unit test
     */
    function __construct($extra_custom_config = null) {

        $this->_local_config = new stdclass();

        global $_CLM_CONFIGS;

        if (empty($_CLM_CONFIGS) == false)
        {
            foreach ($_CLM_CONFIGS as $key => $value) {
                $this->_local_config->{$key} = $value;
            }
        }

        if (empty($extra_custom_config) == false)
        {
            foreach ($extra_custom_config as $key => $value) {
                $this->_local_config->{$key} = $value;
            }
        }

        $this->_instances = new stdclass();
    }

    //endregion Ctor

    //region Methods

    /**
     * Get the config value as setup in the /config/default.php file
     * 
     * @return value 
     *      return the value setup in the config file associate to the specific key.
     *      NULL if the key doesn't exist
     */
    public function get_config(string $config_key) {
        if (isset($this->_local_config->{$config_key}))
            return $this->_local_config->{$config_key};
        return NULL;
    }

    /**
     * Store the instance associate to the specific key
     * 
     * @param string $key
     *      unique key used to store the instance
     * 
     * @param object $instance
     *      instance to store
     * 
     * @return boolean return true if the storage succeed; false if a instance have already been store for the specific key
     */
    public function store(string $key, $instance) {
        if ($instance == NULL ||
            empty($key) ||
            isset($this->_instances->{$key}))
            return FALSE;
        $this->_instances->{$key} = $instance;
        return TRUE;
    }

    /**
     * Gets the specific instance store to$by the specific $Key
     * 
     * @param string $key
     *      unique $key used to store and retreive a specific instance
     * 
     * @return object instance
     *      return the specific instance associate to the specific key; if the key doesn't existing return NULL
     */
    public function get(string $key) {
        if (isset($this->_instances->{$key}))
            return $this->_instances->{$key};
        return NULL;
    }

    //endregion Methods
}