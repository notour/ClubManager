<?php

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

require_once CD_PLUGIN_INTERFACES_PATH . 'iioc_container.php';
require_once CD_PLUGIN_CONFIG_PATH . 'default.php';

/**
 * Default IOC container
 */
final class IocContainer implements IIocContainer
{
    //region Fields

    private $local_config;

    //endregion Fields

    //region Ctor

    /**
     * Initialize a new instance of the class <see cref="IocContainer" />
     * Load data from the /config/default.php
     * 
     * @param array $extra_custom_config
     *      Extra configuration add un dynamic. This array is also used for unit test
     */
    function __constructor(array $extra_custom_config = null) {

        foreach ($configs as $key => $value) {
            $local_config->${$key} = $value;
        }
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
        if (isset($this->local_config->${$config_key}))
            return $this->local_config->${$config_key};
        return NULL;
    }

    //endregion Methods
}