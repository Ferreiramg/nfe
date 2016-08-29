<?php

namespace NFe\Service;

/**
 * Description of AbstractSevice
 *
 * @author Luis Paulo
 */
class AbstractSevice implements InterfaceService
{

    public $content;
    public $timeout=60;
    public $uri;
    public $cuf;
    public $version;

    public function validate()
    {
        if (!$this->content || !$this->cuf || !$this->uri || !$this->version) {
            \NFe\NFeException::servicePrepareError("Parametros vazios para requisicao!");
        }
    }

    public function withVersion($ver)
    {
        $this->version = $ver;
        return $this;
    }

    public function withcUF($uf)
    {
        $this->cuf = $uf;
        return $this;
    }

    public function withBody($body)
    {
        $this->content = $body;
        return $this;
    }

    public function withHeader($headers)
    {
        $this->header = $headers;
        return $this;
    }

    public function withUri($uri)
    {
        $this->uri = $uri;
        return $this;
    }
}
