<?php

namespace Nines\Marco\Record;

/**
 * Description of Record
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Record {

    const LENGTH_BYTES = 5;
    const LEADER_BYTES = 24;
    const RECORD_TERMINATOR = "\x1D";
    const FIELD_TERMINATOR = "\x1E";
    const SUBFIELD_START = "\x1F";
    const ENTRY_LENGTH = 12;
    const DIRECTORY_TERMINATOR = "\x1E";

    private $leader;
    private $data;
    private $fields;

    public function __construct() {
        $this->fields = array();
    }

    public function setLeader($leader) {
        $this->leader = $leader;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function addField(Field $field) {
        $this->fields[] = $field;
        return $this;
    }

    public function getData() {
        return $this->data;
    }

    public function getLeader() {
        return $this->leader;
    }

    public function getFields() {
        return $this->fields;
    }

    public function findField($code, $i1 = null, $i2 = null) {
        $filter = function(Field $field) use($code, $i1, $i2) {
            if($field->getCode() != $code) {
                return false;
            }
            if($i1 !== null && $field->getI1() != $i1) {
                return false;
            }
            if($i2 !== null && $field->getI2() != $i2) {
                return false;
            }
            return true;
        };
        return array_filter($this->fields, $filter);
    }

    public function __toString() {
        $str = $this->leader . "\n";
        foreach ($this->fields as $field) {
            $str .= $field . "\n";
        }
        return $str;
    }

}
