<?php

namespace Mrzkit\CustomTemplates;

use Mrzkit\CustomTemplates\SceneDatum\Scene\NormalScenario;

class Tester
{
    public function test()
    {
        $scenario = new NormalScenario();

        $replaceResult = $scenario->execute();

        var_dump($replaceResult);
    }
}
