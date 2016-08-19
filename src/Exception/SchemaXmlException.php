<?php

namespace NFe;

/**
 * Description of SchemaXmlException
 * @codeCoverageIgnore
 * @author Luis
 */
class SchemaXmlException extends \RuntimeException
{

    public static function validateSchema()
    {
        return new static('Validate Schema Error: ' . static::getSchemaError());
    }

    private static function getSchemaError()
    {
        return print_r(libxml_get_errors(), true);
    }
}
