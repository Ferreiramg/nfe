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
        return new static('Unable to read certificate, get follow error: ' . static::getOpenSSLError());
    }

    public static function unableToOpen() {
        return new static('Unable to open certificate, get follow error: ' . static::getOpenSSLError());
    }

    public static function signContent() {
        return new static(
                'An unexpected error has occurred when sign a content, get follow error: ' . static::getOpenSSLError()
        );
    }

    public static function getPrivateKey() {
        return new static('An error has occurred when get private key, get follow error: ' . static::getOpenSSLError());
    }

    private static function getOpenSSLError() {
        $error = '';
        while ($msg = openssl_error_string()) {
            $error .= "($msg)";
        }
        return $error;
    }

}
