<?php

namespace NFe\Filters;

use NFe\DecorateProcess;
use NFe\Base;

/**
 * Description of ValidateCertificate
 *
 * @author Luis Paulo
 */
class ValidateCertificate extends DecorateProcess
{

    public function proccess(Base $base)
    {
        $base->loadCertificate();
        $this->validDate($base); //validate
        $this->createprocess->proccess($base);
    }

    /**
     * Verifica data do certificado
     * 
     * @return boolean 
     * @throws CertificateException
     */
    private function validDate(Base $base)
    {
        $certificate = $base->getCertificate();
        if ($certificate->isExpired()) {
            throw new \NFe\CertificateException('Certificado Expirou em: ' . $certificate->getValidTo()->format('d/m/Y'));
        }
        return true;
    }
}
