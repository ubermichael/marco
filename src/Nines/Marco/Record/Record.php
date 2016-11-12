<?php

namespace Nines\Marco\Record;

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

    public function __construct() {
		
    }
	
    public function setLeader($leader) {
		$this->leader = $leader;
		return $this;
	}
	public function setDirectory($directory) {
		$this->directory = $directory;
		return $this;
	}

	public function setFieldset($fieldset) {
		$this->fieldset = $fieldset;
		return $this;
	}

		public function setData($data) {
		$this->data = $data;
		return $this;
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
	
	public function __toString() {
		$str = $this->leader . "\n";
		foreach($this->fieldset as $field) {
			$str .= $field . "\n";
		}
		return $str;
	}
}
