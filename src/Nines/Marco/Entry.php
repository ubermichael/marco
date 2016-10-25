<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco;

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
