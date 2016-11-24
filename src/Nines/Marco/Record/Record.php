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
		if( ! is_array($code)) {
			$code = array($code);
		}
		$fields = [];		
		foreach($this->fields as $field) {
			if( ! in_array($field->getCode(), $code)) {
				continue;
			}
			if($i1 !== null && $i1 != $field->getI1()) {
				continue;
			}
			if($i2 !== null && $i2 != $field->getI2()) {
				continue;
			}
			$fields[] = $field;
		}
		return $fields;
	}

	public function __toString() {
		$str = $this->leader . "\n";
		foreach($this->fields as $field) {
			$str .= $field . "\n";
		}
		return $str;
	}
}
