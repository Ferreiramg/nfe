<?php

namespace NFe;

/**
 * Description of NFeRequestException
 * @codeCoverageIgnore
 * @author Luis
 */
class NFeException extends \RuntimeException
{

    public static function errorHandler($errnoc, $errmsg)
    {

        if (empty($errnoc)) {
            return null;
        }
        throw new self($errmsg, $errnoc);
    }

    public static function servicePrepareError($msg="")
    {
        return new static('Get follow error: '.$msg);
    }
}
