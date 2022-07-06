<?php

namespace Mrzkit\CustomTemplates;

abstract class Scenario
{
    /**
     * @desc 定义非表格数据
     * @return array
     */
    abstract public static function single() : array;

    /**
     * @desc 定义表格数据
     * @return array
     */
    abstract public static function multi() : array;

    /**
     * @desc 返回配置
     * @return array[]
     */
    public static function getConfigs() : array
    {
        return [
            "single" => [
                "desc" => "非表格数据",
                "data" => static::single(),
            ],
            "multi"  => [
                "desc" => "表格数据",
                "data" => static::multi(),
            ],
        ];
    }
}
