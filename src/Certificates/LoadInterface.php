<?php

namespace NFe\Certificates;

/**
 *
 * @author luciano.nolasco
 */
interface LoadInterface {

    public function priKey();

    public function certKey();

    public function pubKey();

    public function setCertificate($filepfx);
    
    public function getTmpKeys($key);
}
