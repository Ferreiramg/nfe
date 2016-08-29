<?php

namespace NFe\Template;

/**
 * Description of TemplateXMl
 *
 * @author Luis Paulo
 */
class TemplateXMLElement extends \SimpleXMLElement {

    /**
     * Clean value of all nodes
     * @param \NFe\Template\TemplateXMLElement $child
     * @return \NFe\Template\TemplateXMLElement
     */
    public function clean(TemplateXMLElement $child = null) {
        $child = is_null($child) ? $this : $child;
        foreach ($child as $value) {
            if ($value->count() > 0) {
                $this->clean($value);
            } else {
                $value[0][0] = "";
            }
        }
        return $this;
    }

    /**
     * remove a SimpleXmlElement from it's parent 
     * @return \NFe\Template\TemplateXMLElement 
     */
    public function remove() {
        $node = dom_import_simplexml($this);
        $node->parentNode->removeChild($node);

        return $this;
    }

    public function insertBefore($node) {
        $target_dom = dom_import_simplexml($this);
        $new = $target_dom->parentNode->insertBefore(
                $target_dom->ownerDocument->createElement($node, null), $target_dom->nextSibling
        );
        return simplexml_import_dom($new, self::class);
    }

    public function numberFormat() {
        $node = dom_import_simplexml($this);
        return number_format($node->nodeValue, 2, '.', '');
    }

}
