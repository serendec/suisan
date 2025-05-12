<?php
require_once __DIR__ . '/../class-app-csv-reader.php';
require_once __DIR__ . '/../interface-app-search-service.php';
require_once __DIR__ . '/class-app-resource-document-search-result-item.php';

final class App_Resource_Document_Search_Service implements App_Search_Service_Interface
{
    /**
     * @param string $path
     * @param string $encode
     * @param array $conditions
     * @return App_Resource_Document_Search_Result_Item[]
     */
    public static function searchFromCsv(string $path, string $encode, array $conditions = []): array
    {
        if (!file_exists($path))
            return [];

        $reader = self::makeCsvReader($path, $encode);
        $results = [];

        foreach ($reader->readLine() as $index => $line) {
            if ($index === 0) continue;

            if (self::isMatchesConditions($conditions, $line)) {
                $results[] = App_Resource_Document_Search_Result_Item::createFromCsv($line);
            }
        }

        return $results;
    }

    /**
     * @param array $conditions
     * @param array $line
     * @return bool
     */
    private static function isMatchesConditions(array $conditions, array $line): bool
    {
        $year = isset($line[0]) ? intval($line[0]) : null;
        $type =  $line[1] ?? null;
        $number =  $line[2] ?? null;
        $subNumber =  $line[3] ?? null;
        $keyword = $line[4] ?? null;

        if (isset($conditions['type']) && $conditions['type'] !== $type)
            return false;

        if (isset($conditions['year']) && intval($conditions['year']) !== $year)
            return false;

        if (isset($conditions['number']) && $conditions['number'] !== $number)
            return false;

        if (isset($conditions['sub_number']) && $conditions['sub_number'] !== $subNumber)
            return false;

        if (isset($conditions['keyword']) && strpos($keyword, $conditions['keyword']) === false)
            return false;

        return true;
    }

    /**
     * @param string $path
     * @param string $encode
     * @return App_Csv_Reader
     */
    private static function makeCsvReader(string $path, string $encode): App_Csv_Reader
    {
        return App_Csv_Reader::create($path, $encode);
    }
}