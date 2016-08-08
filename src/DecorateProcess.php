<?php

namespace NFe;

/**
 * Description of DecorateProcess
 *
 * @author lpdev
 */
abstract class DecorateProcess extends ProccessInterface {

    protected $createprocess;

    final public function __construct(ProccessInterface $ci=null) {
        $this->createprocess = $ci;
    }

}
