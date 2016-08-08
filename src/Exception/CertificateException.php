<?php

namespace NFe;

/**
 * Description of CertificateException
 * @codeCoverageIgnore
 * @author Luis
 */
class CertificateException extends \RuntimeException {

    public static function errorHandler($errnoc, $errmsg) {

        if (empty($errnoc)) {
            return null;
        }
        throw new CertificateException($errmsg, $errnoc);
    }

}
