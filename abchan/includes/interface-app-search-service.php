<?php

interface App_Search_Service_Interface
{
    /**
     * @param string $path
     * @param string $encode
     * @param array $conditions
     * @return array
     */
    public static function searchFromCsv(string $path, string $encode, array $conditions = []): array;
}