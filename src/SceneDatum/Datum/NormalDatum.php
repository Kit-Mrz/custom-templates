<?php

namespace Mrzkit\CustomTemplates\SceneDatum\Datum;

use Mrzkit\CustomTemplates\DatumOfficer;

class NormalDatum extends DatumOfficer
{
    public static function getConfig() : array
    {
        $list = [
            [
                'name' => '{邮件}',
                'desc' => '邮件',
                'key'  => 'email',
                'val'  => '',
            ],
            [
                'name' => '{手机号}',
                'desc' => '手机号',
                'key'  => 'mobile',
                'val'  => '',
            ],
            [
                'name' => '{名称}',
                'desc' => '名称',
                'key'  => 'name',
                'val'  => '',
            ],
            [
                'name' => '{省份}',
                'desc' => '省份',
                'key'  => 'provinceId',
                'val'  => '',
            ],
            [
                'name' => '{城市}',
                'desc' => '城市',
                'key'  => 'cityId',
                'val'  => '',
            ],
            [
                'name' => '{地址}',
                'desc' => '地址',
                'key'  => 'address',
                'val'  => '',
            ],
        ];

        return $list;
    }
}
