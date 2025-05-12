<?php
require_once __DIR__ . '/class-app-csv-reader.php';

trait App_Search_Facets_Helper
{
    /**
     * @param string $path
     * @param string $encode
     * @return App_Csv_Reader
     */
    private static function makeCsvReader(string $path, string $encode): App_Csv_Reader
    {
        return App_Csv_Reader::create($path, $encode);
    }

    /**
     * @param $value
     * @return string|null
     */
    private static function cleanValue($value): ?string
    {
        if (is_null($value) || is_bool($value))
            return null;

        $value = trim($value);

        return empty($value) ? null : $value;
    }

    /**
     * @param array $repository
     * @param string $value
     * @return array
     */
    private static function appendValue(array $repository, string $value): array
    {
        if (!in_array($value, $repository))
            $repository[] = $value;

        return $repository;
    }
}