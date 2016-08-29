<?php

namespace NFe\Service;

/**
 * Description of Status
 *
 * @author Luis Paulo
 */
class Status extends AbstractSevice
{

    public function __construct(\NFe\SefazBaseService $sefaz)
    {
        $this->withcUF($sefaz->cUF)
            ->withVersion($sefaz::VERSION_NFEN)
            ->withUri($sefaz->serviceConfig()->NfeStatusServico)
            ->withBody(
                sprintf(
                    '<consStatServ xmlns="%s" versao="%s"><tpAmb>%u</tpAmb><cUF>%u</cUF><xServ>STATUS</xServ></consStatServ>'
                    , $sefaz->getServiceWsdl('status')
                    , $sefaz::URL
                    , $sefaz::VERSION_NFE
                    , $sefaz->type
                    , $sefaz->cUF
                )
        );
    }
}
