<?php

/**
 * Define an IOC container used to retreive all the
 * instance of the system and configurations
 */
interface IIocContainer {

    const Traits  = "IIocContainer";

    /**
     * Get the config value as setup in the /config/default.php file
     * 
     * @return value 
     *      return the value setup in the config file associate to the specific key.
     *      NULL if the key doesn't exist
     */
    public function get_config(string $config_key);
    
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
    public function store(string $key, $instance);

    /**
     * Gets the specific instance store to$by the specific $Key
     * 
     * @param string $key
     *      unique $key used to store and retreive a specific instance
     * 
     * @return object instance
     *      return the specific instance associate to the specific key; if the key doesn't existing return NULL
     */
    public function get(string $key);
}