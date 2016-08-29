<?php

namespace NFe\Request;

/**
 * Description of Stream
 *
 * @author Luis Paulo
 */
class ClientStream
{

    private $response;

    public function response()
    {
        return file_get_contents($this->response);
    }

    public function send(Service $service)
    {
        $prepare = new PrepareRequest($service);
        $contextOptions = array(
            'http' =>
            [
                'method' => 'POST',
                'timeout' => $prepare->timeout,
                'header' => 'application/xml;charset=utf-8;',
                'content' => $prepare->content
            ],
            'ssl' => [
                'verify_peer' => true,
                'local_cert' => $prepare->certificate,
                'ciphers' => 'HIGH:!SSLv2:!SSLv3',
                'disable_compression' => true,
            ]
        );
        $context = stream_context_create($contextOptions);
        return $this->response = fopen($prepare->uri, 'r', null, $context);
    }

    public function progress($notificationCode, $severity, $message, $messageCode, $bytesTransferred, $bytesMax)
    {
        
    }
}
