<?php

namespace NFe\Tests;

/**
 * Description of ProcessTemplateTest
 *
 * @author Luis Paulo
 */
class XMLTemplateTest extends PHPUnit
{

    public function testShouldGetElementsNodeInStdObj()
    {
        $file = file_get_contents(self::XML1_DEP);
        $xml = new \NFe\Template\TemplateXMLElement($file);

        self::assertEquals('31', $xml->infNFe->ide->cUF);
        $xml->infNFe->ide->clean();
        self::assertEquals('', $xml->infNFe->ide->cUF);
        $xml->infNFe->emit->remove();
        $xml->infNFe->ide->insertBefore('emit');
        $xml->infNFe->ide->emit->vPreco = 100;
        self::assertEquals(100.00, $xml->infNFe->ide->emit->vPreco->numberFormat());
    }

}
