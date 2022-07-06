<?php

namespace Mrzkit\CustomTemplates\SceneDatum\Scene;

use Mrzkit\CustomTemplates\Scenario;
use Mrzkit\CustomTemplates\SceneDatum\Datum\NormalDatum;

class NormalScenario extends Scenario
{
    public static function single() : array
    {
        return [
            "key"   => "normal",
            "desc"  => "常规数据",
            "value" => NormalDatum::getConfig(),
        ];
    }

    public static function multi() : array
    {
        return [];
    }

    public static function execute() : string
    {
        $normalDatum = new NormalDatum();

        $template = "Name: {名称}, Email: {邮件}, Mobile: {手机号}, Address: {地址}, Province: {省份}, City: {城市}.";

        $datum = [
            'name'       => '杰哥',
            'email'      => '562591971@qq.com',
            'mobile'     => '13838389438',
            'address'    => '广州Xxx',
            'provinceId' => '广东',
            'cityId'     => '广州',
        ];

        $normalDatum->dataInject($datum);

        $template = $normalDatum->templateInject($template)->replace();

        // Name: 杰哥, Email: 562591971@qq.com, Mobile: 13838389438 省略了。。。。
        var_dump($template);

        return $template;
    }

}
