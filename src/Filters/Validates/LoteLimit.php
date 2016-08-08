<?php

namespace NFe\Filters;

/**
 * Description of LoteLimt
 *
 * @author Luis Paulo
 */
class LoteLimit extends \FilterIterator {

    public function accept() {
       
        if ($this->count() >= 50) {
            $this->setLogProccess('Limite de 50 NFes atingido, processe um novo lote:', $this->getInnerIterator());
            return false;
        }
        return true;
    }

}
