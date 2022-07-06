<?php

namespace Mrzkit\CustomTemplates;

class DatumField
{
    /**
     * @desc 字段名称
     * @var string
     */
    private $name;

    /**
     * @desc 字段解释
     * @var string
     */
    private $desc;

    /**
     * @desc 目标键
     * @var string
     */
    private $key;

    /**
     * @desc 目标值
     * @var mixed
     */
    private $val;

    public function __construct(string $name, string $desc, string $key, $val)
    {
        $this->name = $name;
        $this->desc = $desc;
        $this->key  = $key;
        $this->val  = $val;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDesc() : string
    {
        return $this->desc;
    }

    /**
     * @return string
     */
    public function getKey() : string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getVal()
    {
        return $this->val;
    }
}
