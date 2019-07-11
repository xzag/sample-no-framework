<?php

namespace app\core;

abstract class Configurable
{
    /**
     * @param array $data
     * @return static
     */
    public static function make(array $data, $callback = null)
    {
        $obj = new static();
        foreach ($data as $key => $value) {
            if (property_exists($obj, $key)) {
                $obj->$key = is_callable($callback) ? $callback($value) : $value;
            }
        }
        return $obj;
    }

    /**
     * @param array $data
     * @return static[]
     */
    public static function collection(array $data)
    {
        return array_map(function ($item) {
            return static::make($item);
        }, $data);
    }

    public function toArray()
    {
        $properties = get_object_vars($this);
        return $properties;
    }
}
