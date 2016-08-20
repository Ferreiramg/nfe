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
        throw new self($errmsg, $errnoc);
    }

    public static function unableToRead() {
        return new static('Get follow error: ' . static::getOpenSSLError());
    }

    public static function unableToOpen() {
        return new static('Get follow error: ' . static::getOpenSSLError());
    }

    public static function signContent() {
        return new static(
                'Get follow error: ' . static::getOpenSSLError()
        );
    }

    public static function getPrivateKey() {
        return new static('Get follow error: ' . static::getOpenSSLError());
    }

    private static function getOpenSSLError() {
        $error = '';
        while ($msg = openssl_error_string()) {
            $error .= "($msg)";
        }
        return $error;
    }

}
