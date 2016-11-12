<?php

namespace Nines\Marco\Record;

/**
 * Description of Entry
 *
 * @author mjoyce
 */
class Entry {

    private $field;
    
    private $start;
    
    private $length;
    
    public function __construct($field, $start, $length) {
        $this->field = $field;
        $this->start = $start;
        $this->length = $length;
    }
    
    function getField() {
        return $this->field;
    }

    function getStart() {
        return $this->start;
    }

    function getLength() {
        return $this->length;
    }

    public function __toString() {
        return "{$this->field} {$this->start} {$this->length}";
    }
    
}
