<?php
require_once __DIR__ . '/class-app-resource-assessment-facets.php';
require_once __DIR__ . '/../trait-app-search-facets-helper.php';
require_once __DIR__ . '/../interface-app-search-facets-factory.php';

final class App_Resource_Assessment_Facets_Factory implements App_Search_Facets_Factory_Interface
{
    use App_Search_Facets_Helper;

    /**
     * @param string $path
     * @param string $encode
     * @return App_Resource_Assessment_Facets
     */
    public static function createFromCsv(string $path, string $encode): App_Resource_Assessment_Facets
    {
        $reader = self::makeCsvReader($path, $encode);
        $types  = [];
        $years  = [];

        foreach ($reader->readLine() as $index => $line) {
            if ($index === 0) continue;

            if ($type = self::cleanValue($line[0] ?? null)) {
                $types = self::appendValue($types, $type);
            }

            if ($year = self::cleanValue($line[1] ?? null)) {
                $years = self::appendValue($years, intval($year));
            }
        }

        sort($years);

        return new App_Resource_Assessment_Facets($types, $years);
    }

    /**
     * @return App_Resource_Assessment_Facets
     */
    public static function createEmpty(): App_Resource_Assessment_Facets
    {
        return new App_Resource_Assessment_Facets([], []);
    }
}