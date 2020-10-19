<?php

class FileHandler
{
    public static function saveTxt($path, $text)
    {
        $file = fopen($path, 'a+');
        fwrite($file, $text . PHP_EOL);
        fclose($file);
    }

    public static function readTxt($path)
    {
        $list = array();

        $file = fopen($path, 'r');
        while (!feof($file)) {
            $line = fgets($file);
            $data = explode('*', $line);
            if (count($data) > 0) {
                array_push($list, $data);
            }
        }
        fclose($file);

        return $list;
    }

    public static function saveJson($path, $obj)
    {
        $file = fopen($path, 'w');
        fwrite($file, json_encode($obj, JSON_PRETTY_PRINT));
        fclose($file);
    }

    public static function readJson($path)
    {
        $list = array();

        if (file_exists($path)) {
            $file = fopen($path, 'r');
            $size = filesize($path);
            if ($size > 0) {
                $fread = fread($file, $size);
                $list = json_decode($fread);
            }
            fclose($file);
        }
        return $list;
    }

    public static function saveSerialize($path, $obj)
    {
        $file = fopen($path, 'w');
        fwrite($file, serialize($obj));
        fclose($file);
    }

    public static function readSerialize($path)
    {
        $list = array();

        if (file_exists($path)) {
            $file = fopen($path, 'r');
            $size = filesize($path);
            if ($size > 0) {
                $fread = fread($file, $size);
                $list = unserialize($fread);
            }
            fclose($file);
        }
        return $list;
    }
}
