<?php
declare(strict_types=1);

require_once dirname( __FILE__ ) . '/../clubmanager_const.php';

/**
 * Define base method common to all the manager in charge of a specific model data
 */
interface IDataMngtBase {

    //region Methods

    /**
     * Return a list of all the data filter by the page number and the specific search_filter
     * 
     * @param int $page_number 
     *      Define the number of the page to load by default a page contains 20 objects
     * 
     * @param any $search_filter
     *      Define a specific filter on the data object
     * 
     * @return SearchResult[]
*          return an array of LoadResult object that contains only data identification
     */
    public function search(int $page_number, $search_filter) : array;

    //endregion
}