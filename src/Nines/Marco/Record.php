<?php

namespace Nines\Marco;

use Exception;

/**
 * Description of Record
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Record {

    const RECORD_TERMINATOR = "\x1D";
    const FIELD_TERMINATOR = "\x1E";
    const SUBFIELD_START = "\x1F";

    private $leader;
    private $directory;
    private $fieldset;
    private $data;

    public function __construct($data) {
        if (substr($data, -1) !== self::RECORD_TERMINATOR) {
            throw new Exception("Record should end with \\x1D. Found " . substr($data, -1));
        }
        $length = substr($data, 0, 5);
        if (strlen($data) !== intval($length)) {
            throw new Exception("Expected record length " . intval($length) . " does not match actual length " . strlen($data));
        }
        $this->data = $data;
        $this->leader = new Leader($data);
        $this->directory = new Directory($data, $this->leader);
        $this->fieldset = new FieldSet($data, $this->leader, $this->directory);
    }
    
    public function getField($code, $i1 = null, $i2 = null, $sub = null) {
        return $this->fieldset->getField($code, $i1, $i2, $sub);
    }

    public function getData() {
        return $this->data;
    }

    public function getLeader() {
        return $this->leader;
    }

    public function getDirectory() {
        return $this->directory;
    }
    
    public function getFieldset() {
        return $this->fieldset;
    }
}
