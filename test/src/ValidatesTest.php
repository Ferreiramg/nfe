<?php

namespace NFe\Tests;

use \NFe\ProccessTemplate,
    \NFe\Filters\SchemaValidate,
    \NFe\Template\TemplateXMLElement,
    \NFe\Base;
use NFe\Certificates\Certificate;
Use NFe\Certificates\Reader;

/**
 * Description of ValidatesTest
 *
 * @author Luis Paulo
 */
class ValidatesTest extends PHPUnit
{

    private function _renderTemplate()
    {
        $f = file_get_contents(self::XML1_DEP);
        return new TemplateXMLElement($f);
    }

    public function testValidateSchemasNfe()
    {

        $schema = new SchemaValidate(
            $this->_simpleMock(\NFe\ProccessInterface::class)
        );
        $template = new ProccessTemplate(
            $schema->setSchemaPathFile(self::SCHEMA_NFE)
        );

        $run = $template->setTemplate($this->_renderTemplate());
        $run->proccess(new Base());
    }

    /**
     * @expectedException NFe\SchemaXmlException
     */
    public function testShemaValidateExceptionInvalidXml()
    {
        $template = $this->_renderTemplate();
        $template->infNFe->ide->cUF->remove(); //remove node cUF

        $schema = new SchemaValidate(
            $this->_simpleMock(\NFe\ProccessInterface::class)
        );
        $proccess = new ProccessTemplate(
            $schema->setSchemaPathFile(self::SCHEMA_NFE)
        );

        $run = $proccess->setTemplate($template);
        $run->proccess(new Base());
    }

    public function testValidateDateCertificate()
    {
        $run = new \NFe\Filters\ValidateCertificate($this->_simpleMock(\NFe\ProccessInterface::class));

        $run->proccess($this->_mockBase());
    }

    /**
     * @expectedException \NFe\CertificateException
     * @expectedExceptionMessage Certificado Expirou em: 30/06/2015
     */
    public function testValidateDateCertificateExceptionOutOfDate()
    {
        $run = new \NFe\Filters\ValidateCertificate($this->_simpleMock(\NFe\ProccessInterface::class));

        $mock = $this->_mockBase2();
        $mock->method('getCertificate') //change certificate
            ->will($this->returnValue(new Certificate(
                    new Reader($this->paths, self::CERT2_TEST, self::CERT1_PASS))
        ));

        $run->proccess($mock);
    }
}
