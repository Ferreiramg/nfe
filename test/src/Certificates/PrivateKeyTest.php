<?php

namespace NFe\Certificates\Tests\Certificate;

use NFe\Certificates\PrivateKey;
use NFe\CertificateException;

class PrivateKeyTest extends \NFe\Tests\PHPUnit
{

    public function testShouldInstantiate()
    {
        $key = new PrivateKey($this->_getFile('prikey.pem'));
        $this->assertNotNull($key->sign('nfe'));
        $this->assertNotNull(" ". $key);
    }

    public function testGetExcpetion()
    {
        $this->setExpectedException(CertificateException::class);
        $key = new PrivateKey($this->_getFile('certs.pfx'));
    }
}
