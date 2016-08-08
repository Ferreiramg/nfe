<?php

namespace NFe;

/**
 * Description of ProcessTemplate
 *
 * @author lpdev
 */
class ProccessTemplate extends DecorateProcess {

    private $template;

    public function proccess(Base $base) {
        $base->loadXml($this->template->asXML());
        $this->createprocess->proccess($base);
    }

    public function setTemplate(\SimpleXMLElement $xmlobj) {
        $this->template = $xmlobj;
        return $this;
    }

    /**
     * 
     * @return \NFe\Template\TemplateXMLElement
     */
    public function getTemplate() {
        return $this->template;
    }

}
