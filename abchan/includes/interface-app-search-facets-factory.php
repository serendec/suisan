<?php
require_once __DIR__ . '/interface-app-search-facets.php';

interface App_Search_Facets_Factory_Interface
{
    /**
     * @param string $path
     * @param string $encode
     * @return App_Search_Facets_Interface
     */
    public static function createFromCsv(string $path, string $encode): App_Search_Facets_Interface;

    /**
     * @return App_Search_Facets_Interface
     */
    public static function createEmpty(): App_Search_Facets_Interface;
}