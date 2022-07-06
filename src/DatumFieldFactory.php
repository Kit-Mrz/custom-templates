<?php

namespace Mrzkit\CustomTemplates;

class DatumFieldFactory
{
    /**
     * @return DatumField
     */
    public static function getField(string $name, string $desc, string $key, $val) : DatumField
    {
        return new DatumField($name, $desc, $key, $val);
    }
}
