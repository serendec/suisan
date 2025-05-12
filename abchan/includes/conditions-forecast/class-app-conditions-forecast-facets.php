<?php
require_once __DIR__ . '/../interface-app-search-facets.php';

final class App_Conditions_Forecast_Facets implements App_Search_Facets_Interface
{
    /**
     * @var array
     */
    private array $years;

    /**
     * @var array
     */
    private array $seaAreas;

    /**
     * @var array
     */
    private array $categories;

    /**
     * @param array $years
     * @param array $seaAreas
     * @param array $categories
     */
    public function __construct(array $years, array $seaAreas, array $categories)
    {
        $this->years = $years;
        $this->seaAreas = $seaAreas;
        $this->categories = $categories;
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
    public function getSeaAreas(): array
    {
        return $this->seaAreas;
    }

    /**
     * @return array
     */
    public function getCategories(): array
    {
        return $this->categories;
    }
}