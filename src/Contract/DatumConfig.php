<?php

namespace Mrzkit\CustomTemplates\Contract;

interface DatumConfig
{
    /**
     * @desc 获取配置
     * @return array
     */
    public static function getConfig() : array;
}
