<?php

namespace NFePHP\Common\Tests\Certificate;

use NFe\Certificates\Certificate;
use NFe\CertificateException;

class CertificateTest extends \NFe\Tests\PHPUnit
{

    public function testShouldLoadPfxCertificate()
    {
        $certificate = new Certificate($this->_getFile('certs.pfx'), self::CERT1_PASS);

        self::assertEquals('NFeOO', $certificate->getCompanyName());
        self::assertInstanceOf(\DateTime::class, $certificate->getValidFrom());
        self::assertInstanceOf(\DateTime::class, $certificate->getValidTo());
        self::assertStringEndsNotWith("-----END CERTIFICATE-----", $certificate->getCleanPublicKey());
        self::assertNotNull($certificate->certificate());
        self::assertFalse($certificate->isExpired());

        $dataSigned = $certificate->sign('nfe');
        self::assertTrue($certificate->verify('nfe', $dataSigned));
    }

    public function testShouldGetExceptionWhenLoadPfxCertificate()
    {
        $this->setExpectedException(CertificateException::class);
        new Certificate($this->_getFile('certs.pfx'), 'error');
    }
}
