<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco\Record;

/**
 * Description of Entry
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
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
	
	public function getField() {
		return $this->field;
	}

	public function getStart() {
		return $this->start;
	}

	public function getLength() {
		return $this->length;
	}

	public function setField($field) {
		$this->field = $field;
		return $this;
	}

	public function setStart($start) {
		$this->start = $start;
		return $this;
	}

	public function setLength($length) {
		$this->length = $length;
		return $this;
	}


	
}
