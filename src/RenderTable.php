<?php

namespace Mrzkit\CustomTemplates;

use Mrzkit\CustomTemplates\Contract\DatumContract;
use DomDocument;
use DOMNodeList;
use DOMElement;

class RenderTable
{
    /**
     * 匹配表格
     */
    const MATCH_TABLE_PATTERN = "/<table.*>.*<\/table>/isU";

    /**
     * @var DOMDocument
     */
    private $domDocument;

    /**
     * @var DatumContract[]
     */
    private $datumContracts;

    /**
     * @var string
     */
    private $body;

    public function __construct(array $datumContracts, string $body)
    {
        $this->domDocument    = new DomDocument('1.0', 'UTF-8');
        $this->datumContracts = $datumContracts;
        $this->body           = $body;
    }

    public function getDomDocument() : DOMDocument
    {
        return $this->domDocument;
    }

    public function loadHtml() : bool
    {
        $tableHtml = self::extractTableHtml();

        if (is_null($tableHtml)) {
            return false;
        }

        if ($this->getDomDocument()->loadHtml($tableHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD) !== true) {
            return false;
        }

        return true;
    }

    /**
     * @return DatumContract[]
     */
    public function getDatumContracts() : array
    {
        return $this->datumContracts;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @desc 提取 <TABLE>
     * @param string $body
     * @return string|null
     */
    public function extractTableHtml() : ?string
    {
        if (preg_match(static::MATCH_TABLE_PATTERN, $this->getBody(), $matches)) {
            $tableHtml = mb_convert_encoding($matches[0], 'HTML-ENTITIES', 'UTF-8');
        }

        return $tableHtml ?? null;
    }

    /**
     * @desc
     * @return array|string|string[]|null
     */
    public function execute()
    {
        if ( !$this->loadHtml()) {
            return $this->getBody();
        }

        /** @var DOMNodeList $nodeList */
        $tableNodes = $this->getDomDocument()->getElementsByTagName('table');

        if ($tableNodes->count() <= 0) {
            return $this->getBody();
        }

        // 第一个 table
        $firstTableNode = $tableNodes->item(0);

        /** @var DOMNodeList $trNodes */
        $trNodes = $firstTableNode->getElementsByTagName('tr');

        if ($trNodes->count() <= 0) {
            return $this->getBody();
        }

        // 第一个是表头行，第二个是数据行
        $secondTrNode = $trNodes->item(1);

        if (is_null($secondTrNode)) {
            return $this->getBody();
        }

        // tr 里面没有 td
        if ($secondTrNode->getElementsByTagName('td')->count() <= 0) {
            return $this->getBody();
        }

        foreach ($this->getDatumContracts() as $datumContract) {
            // 复制行
            $cloneSecondTrNode = clone $secondTrNode;

            /** @var DOMNodeList $cloneTdNodes */
            $cloneTdNodes = $cloneSecondTrNode->getElementsByTagName('td');

            foreach ($datumContract->getFields() as $field) {
                /** @var DOMElement $tdNode */
                foreach ($cloneTdNodes as $tdNode) {
                    // 执行替换
                    $tdNode->textContent = str_replace($field->getName(), $field->getVal(), $tdNode->textContent);
                }
            }

            $secondTrNode->parentNode->appendChild($cloneSecondTrNode);
        }

        $secondTrNode->parentNode->removeChild($secondTrNode);

        $saveHtml = $this->getDomDocument()->saveHTML();

        $saveHtml = preg_replace(static::MATCH_TABLE_PATTERN, $saveHtml, $this->getBody(), -1, $count);

        if ($count > 0) {
            return $saveHtml;
        } else {
            return $this->getBody();
        }
    }
}

