<?php

namespace NFe\Certificates\Tests\Certificate;

use NFe\Certificates\PublicKey;

class PublicKeyTest extends \NFe\Tests\PHPUnit
{

    const NFE_SIGN = "HrXqjzmomAralzPLQj1q0QV7zk8uoTFCks5MbsLfpFLCYn/AoZnC+pJEvi6Eds16ZPiZXPjjkD/7Dxj4gDg9LxDKc8/6HE7hwXCpEIPpfaweuaZnx8J5vLmdYYyJdTJUvuGbqcn+XZFxbGpQzh5XTBUvzVEZKtd355cuXx03bQnGBdFvMBbPBjLPiIdWP0kiTcluH9DytkuRf9+Amn3XmeWDCvBMHdF1Uy3d1QK0qaT1VrBa7vKvxrMHkvx0nAX6LzBmw+58nSE74IaBiYePEn5nGb0u3ycvnhs8lTaDNiwh/H5T7a5EJdRrZ1kllLm6btGCrmk/B7aXccBhc8fksg==";

    public function testShouldInstantiate()
    {
        $key = new PublicKey($this->_getFile('pubkey.pem'));
        self::assertFalse($key->isExpired());
    }

    public function testShouldVerifyHash()
    {
        $key = new PublicKey($this->_getFile('pubkey.pem'));
        self::assertFalse($key->verify("error", base64_decode(self::NFE_SIGN)));
        self::assertTrue($key->verify("nfe", base64_decode(self::NFE_SIGN)));
    }
}
