<?php

/**
 * Description of CertificateTest
 *
 * @author Luis Paulo
 */
class CertificateTest extends \NFe\Tests\PHPUnit
{

    /**
     * @test
     */
    public function testCertificateRead()
    {
        $reader = new \NFe\Certificates\Reader($this->paths, 'certs.pfx', self::CERT1_PASS);
        $cert = new \NFe\Certificates\Certificate($reader);
        $assing = $cert->sign('My data to sign');

        self::assertFileExists($cert->getPrivateKeyFile());
        self::assertFileExists($cert->getPublicKeyFile());
        self::assertStringEndsNotWith('-----END CERTIFICATE-----', $cert->getCleanPublicKey());
        self::assertFalse($cert->isExpired());
        self::assertEquals('company', $cert->getCompanyName());
        self::assertInstanceOf(\DateTime::class, $cert->getValidFrom());
        self::assertInstanceOf(\DateTime::class, $cert->getValidTo());
        self::assertEquals(
            1, openssl_verify('My data to sign', $assing, $reader->rawData['cert'], OPENSSL_ALGO_SHA1)
        );
    }

    /**
     * @test
     * @expectedException NFe\CertificateException
     */
    public function testPasswWrog()
    {
        $reader = new \NFe\Certificates\Reader($this->paths, 'certs.pfx', null);
        $cert = new \NFe\Certificates\Certificate($reader);
    }
}
