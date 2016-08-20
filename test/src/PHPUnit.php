<?php

namespace NFe\Tests;

use NFe\Certificates\Certificate;

/**
 * Description of PHPUnit
 *
 * @author Luis Paulo
 */
class PHPUnit extends \PHPUnit_Framework_TestCase
{

    const XML1_DEP = __DIR__ . '/deps/m1s.xml';
    const XML_DEP = __DIR__ . '/deps/m1.xml';
    const SCHEMA_NFE = LOCAL_SCHEMAS . 'nfe_v3.10.xsd';
    const TEST_PATH = __DIR__ . '/deps/';
    const CERT2_TEST = 'cert1day.pfx';
    const CERT1_PASS = '123456';
    const XML_RETURN = __DIR__ . '/deps/autoriza.xml';

    protected $paths;

    protected function setUp()
    {
        $this->paths = new \League\Flysystem\Filesystem(new \League\Flysystem\Adapter\Local(self::TEST_PATH));
    }

    protected function _getFile($file)
    {
        return file_get_contents(self::TEST_PATH . $file);
    }

    protected function _simpleMock($namespace)
    {
        return $this->getMockBuilder($namespace)->getMock();
    }

    protected function _mockBase()
    {
        $mock = $this->getMockBuilder(\NFe\Base::class)->disableOriginalConstructor()->getMock();
        $mock->method('getCertificate')
            ->will($this->returnValue(new Certificate(
                    $this->_getFile('certs.pfx'), self::CERT1_PASS
                    )
        ));
        return $mock;
    }

    protected function _mockBase2()
    {
        return $mock = $this->getMockBuilder(\NFe\Base::class)->disableOriginalConstructor()->getMock();
    }
}
