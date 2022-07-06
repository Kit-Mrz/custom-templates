<?php

namespace Mrzkit\CustomTemplates;

use Closure;
use Illuminate\Support\Arr;
use Mrzkit\CustomTemplates\Contract\DatumConfig;
use Mrzkit\CustomTemplates\Contract\DatumContract;
use UnexpectedValueException;

abstract class DatumOfficer implements DatumContract, DatumConfig
{
    /**
     * @var DatumField[]
     */
    private $fields;

    /**
     * @var string
     */
    private $template;

    /**
     * @return DatumField[]
     */
    public function getFields() : array
    {
        return $this->fields;
    }

    /**
     * @desc
     * @param string $name
     * @return DatumField
     */
    public function get(string $name) : DatumField
    {
        return Arr::get($this->fields, $name);
    }

    /**
     * @desc
     * @param DatumField $field
     * @return bool
     */
    public function put(DatumField $field)
    {
        $fieldName = $field->getName();

        if (isset($this->fields[$fieldName])) {
            throw new UnexpectedValueException("Duplication name={$field->getName()}");
        }

        $this->fields[$fieldName] = $field;

        return true;
    }

    abstract public static function getConfig() : array;

    /**
     * @desc
     * @param array $target
     * @return array
     */
    public function handle(array $target) : array
    {
        $configs = static::getConfig();

        $rs = [];

        foreach ($configs as $config) {
            $val = Arr::get($target, $config['key']);

            $config['val'] = $val ?? $config['val'];

            $field = DatumFieldFactory::getField($config['name'], $config['desc'], $config['key'], $config['val']);

            $rs[] = $this->put($field);
        }

        return $rs;
    }

    public function dataInject($closure) : array
    {
        if ($closure instanceof Closure) {
            $original = $closure();
        } else if (is_array($closure)) {
            $original = $closure;
        } else {
            throw new \InvalidArgumentException("Invalid Argument.");
        }

        $rs = $this->handle($original);

        return $rs;
    }

    /**
     * @return string
     */
    public function getTemplate() : string
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return \App\Supports\TemplateEngines\DatumOfficer
     */
    public function templateInject(string $template) : DatumOfficer
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @desc
     * @return string
     */
    public function replace() : string
    {
        $template = $this->getTemplate();

        $search  = [];
        $replace = [];

        foreach ($this->getFields() as $field) {
            $search[]  = $field->getName();
            $replace[] = $field->getVal();
        }

        if ( !empty($search) && !empty($replace) && strlen($template) > 0) {
            $template = str_replace($search, $replace, $template);
        }

        return $template;
    }
}
