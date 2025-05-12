<?php
require_once __DIR__ . '/class-app-conditions-forecast-facets.php';
require_once __DIR__ . '/../interface-app-search-facets-factory.php';
require_once __DIR__ . '/../trait-app-search-facets-helper.php';

final class App_Conditions_Forecast_Facets_Factory implements App_Search_Facets_Factory_Interface
{
    use App_Search_Facets_Helper;

    /**
     * @param string $path
     * @param string $encode
     * @return App_Conditions_Forecast_Facets
     */
    public static function createFromCsv(string $path, string $encode): App_Conditions_Forecast_Facets
    {
        $reader = self::makeCsvReader($path, $encode);
        $years  = [];
        $seaAreas = [];
        $categories = [];

        foreach ($reader->readLine() as $index => $line) {
            if ($index === 0) continue;

            if ($year = self::cleanValue($line[0] ?? null)) {
                $years = self::appendValue($years, intval($year));
            }

            if ($seaArea = self::cleanValue($line[1] ?? null)) {
                $seaAreas = self::appendValue($seaAreas, $seaArea);
            }

            if ($category = self::cleanValue($line[2] ?? null)) {
                $categories = self::appendValue($categories, $category);
            }
        }

        sort($years);

        return new App_Conditions_Forecast_Facets($years, $seaAreas, $categories);
    }

    /**
     * @return App_Conditions_Forecast_Facets
     */
    public static function createEmpty(): App_Conditions_Forecast_Facets
    {
        return new App_Conditions_Forecast_Facets([], [], []);
    }
}