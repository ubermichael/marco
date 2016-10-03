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

	private $content;
	private $offset;

	public function __construct($data, $baseAddr) {
		$this->content = substr($data, 24, $baseAddr - 1);
		$this->offset = 0;
	}

	/**
	 * @return Entry
	 */
	public function current() {
		return new Entry(
			substr($this->content, $this->offset, 3), 
			substr($this->content, $this->offset + 3, 4), 
			substr($this->content, $this->offset + 7, 5)
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
		return $this->offset < strlen($this->content);
	}

}
