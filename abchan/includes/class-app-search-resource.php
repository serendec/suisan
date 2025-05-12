<?php

require_once __DIR__ . '/interface-app-search-service.php';
require_once __DIR__ . '/class-app-search-facets-service.php';

final class App_Search_Resource
{
    /**
     * @var string
     */
    private string $slug;

    /**
     * @var App_Search_Facets_Service
     */
    private App_Search_Facets_Service $facetsService;

    /**
     * @var App_Search_Service_Interface
     */
    private App_Search_Service_Interface $searchService;

    /**
     * @var string
     */
    private string $csvField;

    /**
     * @var string
     */
    private string $csvEncode;

    /**
     * @param string $slug
     * @param App_Search_Facets_Service $facetsService
     * @param App_Search_Service_Interface $searchService
     * @param string $csvField
     * @param string $csvEncode
     */
    public function __construct(
        string $slug,
        App_Search_Facets_Service $facetsService,
        App_Search_Service_Interface $searchService,
        string $csvField,
        string $csvEncode
    )
    {
        $this->slug = $slug;
        $this->facetsService = $facetsService;
        $this->searchService = $searchService;
        $this->csvField = $csvField;
        $this->csvEncode = $csvEncode;
    }

    /**
     * @param string $slug
     * @param array $config
     * @return self
     */
    public static function createFromConfig(string $slug, array $config): self
    {
        $facetsService = new App_Search_Facets_Service(
            $config['csv_field'],
            self::createFacetsCacheKey($slug),
            self::getCsvPathByField($config['csv_field']),
            $config['csv_encode'],
            new $config['facets_factory']()
        );

        $searchService = new $config['search_service']();

        return new self($slug, $facetsService, $searchService, $config['csv_field'], $config['csv_encode']);
    }

    /**
     * @param string $field
     * @return string|null
     */
    private static function getCsvPathByField(string $field): ?string
    {
        if ($file = get_field($field, 'options'))
            return get_attached_file($file['ID']) ?: null;

        return null;
    }

    /**
     * @param string $slug
     * @return string
     */
    private static function createFacetsCacheKey(string $slug): string
    {
        return sprintf('app_search_facets_%s', $slug);
    }

    /**
     * @return App_Search_Facets_Interface
     */
    public function getFacets(): App_Search_Facets_Interface
    {
        return $this->facetsService->getFacets();
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return App_Search_Facets_Service
     */
    public function getFacetsService(): App_Search_Facets_Service
    {
        return $this->facetsService;
    }

    /**
     * @return App_Search_Service_Interface
     */
    public function getSearchService(): App_Search_Service_Interface
    {
        return $this->searchService;
    }

    /**
     * @param array $conditions
     * @return array
     */
    public function searchFromCsv(array $conditions = []): array
    {
        return $this->searchService->searchFromCsv(self::getCsvPathByField($this->csvField), $this->csvEncode, $conditions);
    }
}