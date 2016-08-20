<?php

namespace NFe\Tests;

use NFe\Tests\PHPUnit;
use \NFe\ProccessTemplate,
    \NFe\Template\TemplateXMLElement;

/**
 * Description of SignNFeTest
 *
 * @author Luis Paulo
 */
class SignNFeTest extends PHPUnit {

    public function testShouldRunChainProccess() {

        $f = file_get_contents(self::XML1_DEP);
        $objxml = new TemplateXMLElement($f);

        $sign = $this->getMockBuilder(\NFe\SignNFe::class)
                ->setConstructorArgs([$this->_simpleMock(\NFe\ProccessInterface::class)])
                ->getMock();

        $sign->expects($this->exactly(1))->method('proccess');

        $procces = new ProccessTemplate($sign);
        $procces->setTemplate($objxml)->proccess($this->_mockBase());
    }

}
