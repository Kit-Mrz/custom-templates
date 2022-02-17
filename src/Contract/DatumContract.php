<?php

namespace Mrzkit\CustomTemplates\Contract;

interface DatumContract
{
    /**
     * @desc 获取字段对象
     * @return array
     */
    public function getFields() : array;
}
