<?php

namespace NFe\Certificates;

/**
 * Description of Certificate
 *
 * @author Luis Paulo
 */
class Certificate implements Certified
{

    private $objValue;

    public function __construct(Reader $reader)
    {
        $this->objValue = $reader;
    }

    public function sign($text, $alg = OPENSSL_ALGO_SHA1)
    {
        return $this->objValue->sign($text, $alg);
    }

    public function getCaInfo()
    {
        
    }

    public function getCompanyName()
    {
        return $this->objValue->companyName;
    }

    public function getPrivateKeyFile()
    {

        return $this->objValue->localPath->getPathPrefix().'/prikey.pem';
    }

    public function getPublicKeyFile()
    {
         return $this->objValue->localPath->getPathPrefix().'/pubkey.pem';
    }

    public function getValidFrom()
    {
        return $this->objValue->validFrom;
    }

    public function getValidTo()
    {
        return $this->objValue->validTo;
    }

    public function isExpired()
    {
        return $this->objValue->isExpired();
    }

    public function getCleanPublicKey()
    {
        return preg_replace('/\s+/', '', strtr($this->objValue->publicKey, array(
            '-----BEGIN CERTIFICATE-----' => '',
            '-----END CERTIFICATE-----' => '')
        ));
    }
}
