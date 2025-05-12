<?php
require_once __DIR__ . '/../interface-app-search-facets.php';

final class App_Resource_Assessment_Facets implements App_Search_Facets_Interface
{
    /**
     * @var array
     */
    private array $types;

    /**
     * @var array
     */
    private array $years;

    /**
     * @param array $types
     * @param array $years
     */
    public function __construct(array $types, array $years)
    {
        $this->types = $types;
        $this->years = $years;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @return array
     */
    public function getYears(): array
    {
        return $this->years;
    }
}