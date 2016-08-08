<?php

namespace NFe;

/**
 * Description of NFeRequestException
 * @codeCoverageIgnore
 * @author Luis
 */
class NFeException extends \RuntimeException {

    public static function errorHandler($errnoc, $errmsg) {

        if (empty($errnoc)) {
            return null;
        }
        throw new NFeException($errmsg, $errnoc);
    }

}
