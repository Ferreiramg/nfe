<?php

namespace NFe\Certificates;

use NFe\CertificateException;

/**
 * Description of LoadA1
 *
 * @author Luis Paulo
 */
class LoadA1 implements LoadInterface {

    private $file;
    private $passw;
    private $x509certdata = [];
    private $keys = ['ca' => 'ca', 'pri' => 'pri', 'cert' => 'cert'];

    public function __construct($filename, $password) {
        $this->passw = $password;
        $this->setCertificate($filename);
        $this->load();
    }

    public function priKey() {
        return $this->x509certdata['pkey'];
    }

    public function certKey() {
        return $this->x509certdata['pkey'] . "\r\n" . $this->x509certdata['cert'];
    }

    public function pubKey() {
        return $this->x509certdata['cert'];
    }

    public function setCertificate($filepfx) {
        if (!file_exists($filepfx) && !is_writable($filepfx)) {
            throw new CertificateException("Não é possivel fazer a leitura do arquivo: " . $filepfx);
        }
        $this->file = file_get_contents($filepfx);
    }

    private function load() {
        if (!openssl_pkcs12_read($this->file, $this->x509certdata, $this->passw)) {
            throw new CertificateException(
            strpos(openssl_error_string(), '23076071') ? "Senhas não conferem!" : openssl_error_string()
            );
        }
    }

    /**
     * 
     * @param string $key
     * @return string
     */
    public function getTmpKeys($key) {
        if (isset($this->keys[$key])) {
            return (string) sys_get_temp_dir() . '/' . $this->keys[$key] . '.pem';
        }
        throw new CertificateException("Arquivo não foi carregado " . $this->keys[$key]);
    }

}
