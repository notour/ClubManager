<?php

/**
 * Define all the informations
 * provide by a web query
 */
interface IQuery {

    const Traits = "IQuery";

    /**
     * return the query argument associate to the name pass in argument
     * if the value in not present in the path the default value will be returned.
     * 
     * @param string $query_key
     *      define the name of the query argument
     * 
     * @param any $default_value
     *      define the default value to return if the current key doesn't existe in the path' query segment
     * 
     * @return any
     *      return the value found or the default one
     */
    function get_query_var(string $query_key, $default_value);
}