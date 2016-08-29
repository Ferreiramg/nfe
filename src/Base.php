<?php

namespace NFe;

use \League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;

/**
 * Description of Base
 *
 * @codeCoverageIgnore
 * @author lpdev
 */
class Base
{

    /**
     *
     * @var \DOMDocument 
     */
    public $xml;

    /**
     *
     * @var  \NFe\Certificates\LoadInterface 
     */
    private $certificate;

    public function loadXml($xmlstring)
    {
        if (($this->xml instanceof \DOMDocument) === true) {
            return null;
        }
        libxml_use_internal_errors(true); //get errors on throw Exception
        $this->xml = new \DOMDocument('1.0', 'utf-8');
        $this->xml->formatOutput = false;
        $this->xml->preserveWhiteSpace = false;
        $this->xml->loadXML((string) $xmlstring, LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
    }

    public function loadCertificate()
    {
        if (($this->certificate instanceof Certificates\Certified) === true) {
            return $this;
        }
        $local = new Filesystem(new Local(LOCAL_CERT));
        $this->certificate = new Certificates\Certificate(
            $local->read(NAME_CERT), PASSW_CERT
        );

        return $this;
    }

    public function getCertificate()
    {
        return $this->certificate;
    }
    
    public function preparTempCert(){
        $this->loadCertificate();
        $local->write('cert.pem', $this->certificate->certificate());
        return $local->getAdapter(). '/cert.pem';
    }
}
