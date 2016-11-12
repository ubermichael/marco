<?php

namespace Nines\Marco\Record;

use Iterator;

/**
 * Description of Directory
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Directory implements Iterator {
	
	const ENTRY_LENGTH = 12;
	
	const DIRECTORY_TERMINATOR = "\x1E";
	
	private $fields;
	
	private $data;
	
	private $offset;
	
	public function __construct($data, Leader $leader) {
		$this->fields = array();
		$this->data = substr(
			$data, 
			Leader::LEADER_BYTES, 
			$leader->getBaseAddress() - Leader::LEADER_BYTES - 1
		);
	}
	
	public function getData() {
		return $this->data;
	}
	
	/**
	 * @return Entry
	 */
	public function current() {
		return new Entry (
            substr($this->data, $this->offset, 3),
            substr($this->data, $this->offset+7, 5),
            substr($this->data, $this->offset+3, 4)			
		);
	}

	public function key() {
		return $this->offset / self::ENTRY_LENGTH;
	}

	public function next() {
		$this->offset += self::ENTRY_LENGTH;
	}

	public function rewind() {
		$this->offset = 0;
	}

	public function valid() {
		return $this->offset < strlen($this->data);
	}

}
