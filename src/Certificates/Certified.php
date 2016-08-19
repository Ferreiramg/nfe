<?php

namespace NFe\Certificates;

/**
 *
 * @author Luis Paulo
 */
interface Certified
{

    public function getCompanyName();

    public function getPrivateKeyFile();

    public function getPublicKeyFile();

    public function getCleanPublicKey();

    public function certificate();

    public function getCaInfo();

    public function getValidFrom();

    public function getValidTo();

    public function isExpired();

    public function sign($text, $alg = OPENSSL_ALGO_SHA1);
}
