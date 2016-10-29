<?php

namespace Nines\Marco;

class Field {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getCode($subcode = false) {
        if($subcode) {
            return substr($this->data, 0, 6);
        }
        return substr($this->data, 0, 3);
    }

    public function isControl() {
        return substr($this->data, 0, 2) === '00';
    }

    public function getInd1() {
        if ($this->isControl()) {
            return ' ';
        }
        return $this->data[3];
    }

    public function getInd2() {
        if ($this->isControl()) {
            return ' ';
        }
        return $this->data[4];
    }

    public function getSubCode() {
        if ($this->isControl()) {
            return ' ';
        }
        return $this->data[5];
    }

    public function getData() {
        return substr($this->data, 6);
    }

    public function __toString() {
        return "={$this->getCode()} {$this->getInd1()}{$this->getInd2()} \${$this->getSubCode()} {$this->getData()}";
    }

}
