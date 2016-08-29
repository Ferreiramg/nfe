<?php

namespace NFe\Service;

/**
 *
 * @author Luis Paulo
 */
interface InterfaceService
{
    public function withUri($uri);
    public function withHeader($headers);
    public function withBody($body);
}
