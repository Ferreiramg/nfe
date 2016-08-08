<?php

namespace NFe\Filters;

use NFe\DecorateProcess;
use NFe\Base;
use NFe\SchemaXmlException;
use \DOMDocument;

/**
 * Description of SchemaValidate
 *
 * @author Luis Paulo
 */
class SchemaValidate extends DecorateProcess {

    private $schemaPath;

    public function proccess(Base $base) {
        $this->validate($base->xml);
        $this->createprocess->proccess($base);
    }

    /**
     * 
     * @param string $pathfile
     * @return \NFe\Filters\SchemaValidate
     */
    public function setSchemaPathFile($pathfile) {
        $this->schemaPath = $pathfile;
        return $this;
    }

    private function validate(DOMDocument $xmldc) {
        libxml_clear_errors();
        if (!$xmldc->schemaValidate($this->schemaPath)) {
            throw new SchemaXmlException(print_r(libxml_get_errors(), true));
        }
        return true;
    }

}
