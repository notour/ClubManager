<?php

/**
 * Define an IOC container used to retreive all the
 * instance of the system and configurations
 */
interface IIocContainer {

    /**
     * Get the config value as setup in the /config/default.php file
     * 
     * @return value 
     *      return the value setup in the config file associate to the specific key.
     *      NULL if the key doesn't exist
     */
    public function get_config(string $config_key);
}