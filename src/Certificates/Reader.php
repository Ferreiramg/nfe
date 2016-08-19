<?php

namespace NFe\Certificates;

use NFe\CertificateException;

/**
 * Description of Reader
 *
 * @author Luis Paulo
 */
class Reader
{

    /**
     * @var string
     */
    public $companyName;

    /**
     * @var string
     */
    public $privateKey;

    /**
     * @var string
     */
    public $publicKey;

    /**
     * @var \DateTime
     */
    public $validFrom;

    /**
     * @var \DateTime
     */
    public $validTo;

    /**
     * @var string
     */
    public $rawData = [];

    /**
     *
     * @var \League\Flysystem\Filesystem 
     */
    public $localPath;

    public function __construct(\League\Flysystem\Filesystem $local, $filename, $passw)
    {
        $this->localPath = $local->getAdapter();
        $this->load($local->read($filename), $passw);
        $this->saveTmpPemFiles($local);
    }

    private function load($content, $password)
    {
        if (!openssl_pkcs12_read($content, $this->rawData, $password)) {
            throw CertificateException::unableToRead();
        }
        if (!$resource = openssl_x509_read($this->rawData['cert'])) {
            throw CertificateException::unableToOpen();
        }
        $detail = openssl_x509_parse($resource, false);
        $this->companyName = $detail['subject']['organizationName'];
        $this->validFrom = \DateTime::createFromFormat('ymdHis\Z', $detail['validFrom']);
        $this->validTo = \DateTime::createFromFormat('ymdHis\Z', $detail['validTo']);
        $this->privateKey = $this->rawData['pkey'];
        $this->publicKey = $this->rawData['cert'];
    }

    private function saveTmpPemFiles(\League\Flysystem\Filesystem $local)
    {
//        if (GET_CERT_FROM_CACHE && $local->has('prikey.pem' ) && $local->has('prikey.pem' ) ) {
//            return null;
//        }
        $local->put('prikey.pem', $this->privateKey);
        $local->put('pubkey.pem', $this->publicKey);
    }

    /**
     * Check if certificate has been expired.
     * @return bool Returns true when it is truth, otherwise false.
     */
    public function isExpired()
    {
        $now = new \DateTime('now');
        return $this->validTo < $now;
    }

    /**
     * Encrypt a content
     * @param string $content
     * @param int $algorithm type encrypt: default OPENSSL_ALGO_SHA1
     * @return string
     * @throws Nfe\CertificateException
     */
    public function sign($content, $algorithm = OPENSSL_ALGO_SHA1)
    {
        if (!$privateResource = openssl_pkey_get_private($this->privateKey)) {
            throw CertificateException::getPrivateKey();
        }
        $encryptedData = '';
        if (!openssl_sign($content, $encryptedData, $privateResource, $algorithm)) {
            throw CertificateException::signContent();
        }
        return $encryptedData;
    }

    public function __destruct()
    {
        ;
    }
}
