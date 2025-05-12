<?php
trait App_Input_Helper
{
    /**
     * @param array $input
     * @param $key
     * @return bool
     */
    private static function arrayInputExists(array $input, $key): bool
    {
        return self::inputExists($input[$key] ?? null);
    }

    /**
     * @param $value
     * @return bool
     */
    private static function inputExists($value): bool
    {
        $value = trim(strval($value));
        return $value !== '';
    }
}