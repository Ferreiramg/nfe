<?php

namespace NFe\Request;

/**
 * Description of PrepareRequest
 *
 * @author Luis Paulo
 */
class PrepareRequest
{

    public $header;
    public $content;
    public $timeout;
    public $uri;

    public function __construct(\NFe\Service\AbstractSevice $service)
    {
        $service->validate();
        $this->uri = $service->uri;
        $this->content = $service->content;
        $this->header = $this->header;
        $this->timeout = $service->timeout;
        $this->contentEnvolope($service);
    }

    private function contentEnvolope(\NFe\Service\AbstractSevice $service)
    {

        $this->content = <<<XML
            <?xml version="1.0" encoding="utf-8"?>
            <soap12:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap12="http://www.w3.org/2003/05/soap-envelope">
            <soap12:Header><nfeCabecMsg xmlns="$this->uri"><cUF>$service->UF</cUF><versaoDados>$service->version</versaoDados></nfeCabecMsg></soap12:Header>
            <soap12:Body><nfeDadosMsg xmlns="$this->uri">$this->content</nfeDadosMsg></soap12:Body>
            </soap12:Envelope>
XML;
    }
}
