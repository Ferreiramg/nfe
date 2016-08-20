<?php

namespace NFe\Certificates;

/**
 *
 * @author Luis Paulo
 */
interface Certified
{

    public function getCleanPublicKey();

    public function getPrivateKey();

    public function getPublicKey();

    public function certificate();

    public function getCaInfo();

    public function isExpired();
}
