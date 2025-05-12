<?php
require_once __DIR__ . '/../interface-app-search-facets.php';

final class App_Resource_Document_Facets implements App_Search_Facets_Interface
{
    /**
     * @var array
     */
    private array $years;

    /**
     * @var array
     */
    private array $types;

    /**
     * @param array $years
     * @param array $types
     */
    public function __construct(array $years, array $types)
    {
        $this->years = $years;
        $this->types = $types;
    }

    /**
     * @return array
     */
    public function getYears(): array
    {
        return $this->years;
    }

    /**
     * @return array
     */
    public function getTypes(): array
    {
        return $this->types;
    }
}