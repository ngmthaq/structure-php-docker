<?php

namespace Src\Helpers;

final class Hash
{
    /**
     * Hash a string using md5 function
     * 
     * @param string $plain
     * @return string
     */
    public static function make(string $plain)
    {
        return md5($plain);
    }

    /**
     * Compare plain text and hash text
     * 
     * @param string $plain
     * @param string $hashed
     * @return bool
     */
    public static function check(string $plain, string $hashed)
    {
        return self::make($plain) === $hashed;
    }

    /**
     * Encrypt string (Row fence cipher)
     * 
     * @param string $input
     * @param int $key
     * @param string $padding
     * @return array
     */
    public static function rowFenceEncrypt($input, $key = 0, $padding = "=")
    {
        if ($input === null) throw new \Exception("Input cannot be null");
        if ($key < 0) throw new \Exception("Key cannot be null");
        if ($input === "") return array("output" => "", "key" => $key);

        $text_length = strlen($input);
        $key = $key === 0 ? rand(2, $text_length) : $key;
        $array_text = str_split($input);
        $rows = array();

        for ($i = 0; $i < $key; $i++) {
            $rows[$i] = array();
        }

        for ($i = 0; $i < $key; $i++) {
            for ($j = 0; $j < ceil($text_length / $key); $j++) {
                $pos = ($key * $j) + $i;
                $rows[$i][] = isset($array_text[$pos]) ? $array_text[$pos] : $padding;
            }
        }

        $output = implode("", array_map(function ($row) {
            return implode("", $row);
        }, $rows));

        return array("output" => $output, "key" => $key);
    }

    /**
     * Decrypt string (Row fence cipher)
     * 
     * @param string $input
     * @param int $key
     * @param string $padding
     * @return string
     */
    public static function rowFenceDecrypt($input, $key, $padding = "=")
    {
        if (empty($input)) throw new \Exception("Input cannot be null");
        if (empty($key)) throw new \Exception("Key cannot be null");
        $text_length = strlen($input);
        $array_text = str_split($input);
        $columns = round($text_length / $key);
        $rows = array();
        $plain_rows = array();

        for ($i = 0; $i < $key; $i++) {
            for ($j = 0; $j < $columns; $j++) {
                $pos = $i * $columns + $j;
                $rows[$i][] = $array_text[$pos];
            }
        }

        for ($p = 0; $p < $columns; $p++) {
            $plain_rows[$p] = array_map(function ($row) use ($p) {
                return $row[$p];
            }, $rows);
        }

        $output = implode("", array_map(function ($row) {
            return implode("", $row);
        }, $plain_rows));

        return str_replace($padding, "", $output);
    }
}
