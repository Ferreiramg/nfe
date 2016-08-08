<?php

namespace NFe\Filters;

use NFe\DecorateProcess;
use NFe\Base;

/**
 * Description of ValidateCertificate
 *
 * @author Luis Paulo
 */
class ValidateCertificate extends DecorateProcess {

    public function proccess(Base $base) {
        $this->validDateCerts($base);//validate
        $this->createprocess->proccess($base);
    }

    /**
     * Verifica data do certificado
     * 
     * @return boolean 
     * @throws CertificateException
     */
    private function validDateCerts(Base $base) {
        $base->loadCertificate();
        $dados = openssl_x509_parse(
                openssl_x509_read((string) $base->getCertificate()->certload->pubKey())
        );
        $date = new \DateTime('now');

        $datenow = $date->format('U');
        $date->setTimestamp($dados['validTo_time_t']);
        $dateCert = $date->format('U');

        if ($dateCert < $datenow) {
            throw new \NFe\CertificateException('Certificado Expirou em: ' . $date->format('d/m/Y'));
        }
        return true;
    }

}
