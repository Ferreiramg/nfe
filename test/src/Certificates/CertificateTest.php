<?php

/**
 * Description of CertificateTest
 *
 * @author Luis Paulo
 */
class CertificateTest extends \NFe\Tests\PHPUnit
{

    public function testcertificateRead()
    {
        $reader = new \NFe\Certificates\Reader($this->paths, 'certs.pfx', self::CERT1_PASS);
        $cert = new \NFe\Certificates\Certificate($reader);

        self::assertFileExists($cert->getPrivateKeyFile());
        self::assertStringEndsNotWith('-----END CERTIFICATE-----', $cert->getCleanPublicKey());
        self::assertFalse($cert->isExpired());
        self::assertEquals('company', $cert->getCompanyName());
    }
}
