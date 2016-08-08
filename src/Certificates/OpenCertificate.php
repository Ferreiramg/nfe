<?php

namespace NFe\Certificates;

/**
 * Description of Certificate
 *
 * @author Luis Paulo
 */
class OpenCertificate {

    public $certload;

    public function __construct(LoadInterface $certfile) {
        $this->certload = $certfile;
        $this->saveTmpCert();
    }

    public function getLoaded() {
        return $this->certload;
    }

    /**
     * Abre certificado para assinatura!
     * @param string $data 
     * @return string Hash signature encode 64
     */
    public function signOpenssl($data) {
        $signature = null;
        openssl_sign($data, $signature, $this->getPrivateKey());
        return base64_encode($signature);
    }

    public function cleanCert() {
        return preg_replace('/\s+/', '', strtr($this->certload->pubKey(), array(
            '-----BEGIN CERTIFICATE-----' => '',
            '-----END CERTIFICATE-----' => '')
        ));
    }

    public function getPrivateKey() {
        return openssl_get_privatekey((string) $this->certload->priKey());
    }

    private function saveTmpCert() {
        file_put_contents(sys_get_temp_dir() . '/ca.pem', $this->certload->pubKey());
        file_put_contents(sys_get_temp_dir() . '/pri.pem', $this->certload->priKey());
        file_put_contents(sys_get_temp_dir() . '/cert.pem', $this->certload->certKey());
    }

}
