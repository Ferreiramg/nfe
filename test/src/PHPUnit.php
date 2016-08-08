<?php

namespace NFe\Tests;

/**
 * Description of PHPUnit
 *
 * @author Luis Paulo
 */
class PHPUnit extends \PHPUnit_Framework_TestCase {


    const XML1_DEP = __DIR__ . '/deps/m1s.xml';
    const XML_DEP = __DIR__ . '/deps/m1.xml';
    const SCHEMA_NFE = LOCAL_SCHEMAS . 'nfe_v3.10.xsd';
    const CERT1_TEST = __DIR__ . '/deps/certs.pfx';
    const CERT2_TEST = __DIR__ . '/deps/cert1day.pfx';
    const CERT1_PASS = '123456';
    const XML_RETURN = __DIR__ . '/deps/autoriza.xml';

    protected function _simpleMock($namespace) {
        return $this->getMockBuilder($namespace)->getMock();
    }

    protected function _mockBase() {
        $mock = $this->getMockBuilder(\NFe\Base::class)->disableOriginalConstructor()->getMock();
        $mock->method('getCertificate')
                ->will($this->returnValue(new \NFe\Certificates\OpenCertificate(
                                new \NFe\Certificates\LoadA1(self::CERT1_TEST, self::CERT1_PASS))
        ));
        return $mock;
    }
    
    protected  function _mockBase2(){
        return  $mock = $this->getMockBuilder(\NFe\Base::class)->disableOriginalConstructor()->getMock();
    }
}
