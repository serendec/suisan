<?php

require_once __DIR__ . '/interface-app-search-facets-factory.php';
require_once __DIR__ . '/interface-app-search-facets.php';

final class App_Search_Facets_Service
{
    /**
     * @var string
     */
    private string $fieldName;

    /**
     * @var string
     */
    private string $cacheKey;

    /**
     * @var string|null
     */
    private ?string $csvPath;

    /**
     * @var string
     */
    private string $csvEncode;

    /**
     * @var App_Search_Facets_Factory_Interface
     */
    private App_Search_Facets_Factory_Interface $factory;

    /**
     * @param string $fieldName
     * @param string $cacheKey
     * @param string|null $csvPath
     * @param string $csvEncode
     * @param App_Search_Facets_Factory_Interface $factory
     */
    public function __construct(
        string $fieldName,
        string $cacheKey,
        ?string $csvPath,
        string $csvEncode,
        App_Search_Facets_Factory_Interface $factory
    )
    {
        $this->fieldName = $fieldName;
        $this->cacheKey = $cacheKey;
        $this->csvPath = $csvPath;
        $this->csvEncode = $csvEncode;
        $this->factory = $factory;

        add_filter(sprintf('acf/update_value/name=%s', $this->fieldName), function ($value) {
            $this->clearCache();
            return $value;
        });

        add_filter('acf/upload_prefilter', function ($errors, $file, $field) {
            if ($field['name'] === $this->fieldName) {
                add_filter('map_meta_cap', [$this, 'allowUnfilteredUpload'], PHP_INT_MAX, 4);
            }

            return $errors;
        }, 10, 3);
    }

    /**
     * @param $caps
     * @param $cap
     * @param $userId
     * @param $args
     * @return mixed
     */
    public function allowUnfilteredUpload($caps, $cap, $userId, $args) {
        if ($cap !== 'unfiltered_upload')
            return $caps;

        if (($key = array_search('do_not_allow', $caps)) !== false) {
            $caps[$key] = 'unfiltered_upload';
        }

        return $caps;
    }

    /**
     * @return void
     */
    private function clearCache(): void
    {
        delete_transient($this->cacheKey);
    }

    /**
     * @return App_Search_Facets_Interface
     */
    public function getFacets(): App_Search_Facets_Interface
    {
        if ($cache = get_transient($this->cacheKey))
            return $cache;

        if ($this->csvPath && file_exists($this->csvPath)) {
            $facets = $this->factory->createFromCsv($this->csvPath, $this->csvEncode);
            set_transient($this->cacheKey, $facets);
        } else {
            $facets = $this->factory->createEmpty();
        }

        return $facets;
    }
}