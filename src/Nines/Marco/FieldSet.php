<?php

namespace Nines\Marco;

use Iterator;

class FieldSet implements Iterator {

    private $fields;
    private $position;

    public function __construct($data, Leader $leader, Directory $directory) {
        $this->position = 0;
        $this->fields = array();
        
        $base = $leader->getBaseAddress();
        foreach ($directory as $entry) {
            $fieldData = substr($data, $base + $entry->getStart(), $entry->getLength());
            if (substr($entry->getField(), 0, 2) === '00') {
                $this->fields[] = new Field($entry->getField() . '   ' . substr($fieldData, 0, -1));
                continue;
            }
            $fieldList = explode(Record::SUBFIELD_START, $fieldData);
            $fieldList[count($fieldList) - 1] = substr($fieldList[count($fieldList) - 1], 0, -1);
            for ($i = 1; $i < count($fieldList); ++$i) {
                $this->fields[] = new Field($entry->getField() . substr($fieldData, 0, 2) . $fieldList[$i]);
            }
        }
    }

    public function current() {
        if($this->valid()) {
            return $this->fields[$this->position];
        }
        return null;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        $this->position++;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function valid() {
        return ($this->position < count($this->fields));
    }

}
