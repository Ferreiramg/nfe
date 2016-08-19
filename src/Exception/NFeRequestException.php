<?php

namespace NFe;

/**
 * Description of NFeRequestException
 * @codeCoverageIgnore
 * @author Luis
 */
class NFeRequestException extends \RuntimeException {

    public static function errorHandler($errnoc, $errmsg) {

        if (empty($errnoc)) {
            return null;
        }
        throw new self($errmsg, $errnoc);
    }

}
