<?php

namespace NFe;

/**
 * Description of SingNFe
 *
 * @author lpdev
 */
class SignNFe extends DecorateProcess {

    const DSING = 'http://www.w3.org/2000/09/xmldsig#',
            CANONMETH = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315',
            SIGMETH = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1',
            TRANSFMETH_1 = 'http://www.w3.org/2000/09/xmldsig#enveloped-signature',
            TRANSFMETH_2 = 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315',
            DIGESTMETH = 'http://www.w3.org/2000/09/xmldsig#sha1';

    private $xml;

    public function proccess(Base $base) {
        if ($this->hasSignature($base->xml) === false) {
            $this->sign($base);
        }
        $this->createprocess->proccess($base);
    }

    public function hasSignature(\DOMDocument $xmldc) {
        return ( $xmldc->getElementsByTagName('Signature')->item(0) instanceof \DOMElement );
    }

    public function getXMl() {
        return $this->xml;
    }

    public function sign(Base $base) {
        $cert = $base->loadCertificate()->getCertificate();
        $node = $base->xml->getElementsByTagName('infNFe')->item(0);
        $root = $base->xml->getElementsByTagName('NFe')->item(0);
        $dados = $node->C14N(false, false);
        $Signature = $base->xml->createElementNS(self::DSING, 'Signature');
        $root->appendChild($Signature);
        $SignedInfo = $base->xml->createElement('SignedInfo');
        $Signature->appendChild($SignedInfo);
        $newNode = $base->xml->createElement('CanonicalizationMethod');
        $SignedInfo->appendChild($newNode);
        $newNode->setAttribute('Algorithm', self::CANONMETH);
        $newNode = $base->xml->createElement('SignatureMethod');
        $SignedInfo->appendChild($newNode);
        $newNode->setAttribute('Algorithm', self::SIGMETH);
        $Reference = $base->xml->createElement('Reference');
        $SignedInfo->appendChild($Reference);
        $Reference->setAttribute('URI', '#' . $node->getAttribute("Id"));
        $Transforms = $base->xml->createElement('Transforms');
        $Reference->appendChild($Transforms);
        $newNode = $base->xml->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm', self::TRANSFMETH_1);
        $newNode = $base->xml->createElement('Transform');
        $Transforms->appendChild($newNode);
        $newNode->setAttribute('Algorithm', self::TRANSFMETH_2);
        $newNode = $base->xml->createElement('DigestMethod');
        $Reference->appendChild($newNode);
        $newNode->setAttribute('Algorithm', self::DIGESTMETH);
        $newNode = $base->xml->createElement('DigestValue', base64_encode(hash('sha1', $dados, true)));
        $Reference->appendChild($newNode);
        $newNode = $base->xml->createElement(
                'SignatureValue', $cert->signOpenssl($SignedInfo->C14N(false, false)
                )
        );
        $Signature->appendChild($newNode);
        $KeyInfo = $base->xml->createElement('KeyInfo');
        $Signature->appendChild($KeyInfo);
        $X509Data = $base->xml->createElement('X509Data');
        $KeyInfo->appendChild($X509Data);
        $newNode = $base->xml->createElement('X509Certificate', $cert->cleanCert());
        $X509Data->appendChild($newNode);
        $this->xml = $base->xml->saveXML();
    }

}
