<?php

namespace NFe\Certificates;

use NFe\CertificateException;

/**
 * Description of Reader
 *
 * @author Luis Paulo
 */
class Certificate implements SignatureInterface, VerificationInterface, Certified
{

    /**
     * @var string
     */
    public $privateKey;

    /**
     * @var string
     */
    public $publicKey;

    public function __construct($content, $passw)
    {
        $this->read($content, $passw);
    }

    private function read($content, $password)
    {
        $certs = [];
        if (!openssl_pkcs12_read($content, $certs, $password)) {
            throw CertificateException::unableToRead();
        }
        $this->privateKey = new PrivateKey($certs['pkey']);
        $this->publicKey = new PublicKey($certs['cert']);
    }

    /**
     * Gets company name.
     * @return string
     */
    public function getCompanyName()
    {
        return $this->publicKey->commonName;
    }

    /**
     * Gets start date.
     * @return \DateTime Returns start date.
     */
    public function getValidFrom()
    {
        return $this->publicKey->validFrom;
    }

    /**
     * Gets end date.
     * @return \DateTime Returns end date.
     */
    public function getValidTo()
    {
        return $this->publicKey->validTo;
    }

    /**
     * Check if certificate has been expired.
     * @return bool Returns true when it is truth, otherwise false.
     */
    public function isExpired()
    {
        return $this->publicKey->isExpired();
    }

    /**
     * {@inheritdoc}
     */
    public function sign($content, $algorithm = OPENSSL_ALGO_SHA1)
    {
        return $this->privateKey->sign($content, $algorithm);
    }

    /**
     * {@inheritdoc}
     */
    public function verify($data, $signature, $algorithm = OPENSSL_ALGO_SHA1)
    {
        return $this->publicKey->verify($data, $signature, $algorithm);
    }

    public function certificate()
    {
        return $this->privateKey . "\r\n" . $this->publicKey;
    }

    public function getCaInfo()
    {
        
    }

    public function getCleanPublicKey()
    {
        return preg_replace('/\s+/', '', strtr($this->publicKey, array(
            '-----BEGIN CERTIFICATE-----' => '',
            '-----END CERTIFICATE-----' => '')
        ));
    }

    public function getPrivateKey()
    {
        
    }

    public function getPublicKey()
    {
        
    }
}
