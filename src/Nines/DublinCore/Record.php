<?php

namespace Nines\DublinCore;

use Iterator;

/**
 * Description of Record
 *
 * @todo use doctrine/collections for storing fields.
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Record implements Iterator {

	private $data;
	
	private $position;
	
	public function __construct() {
		$this->data = array();
		$this->position = 0;
	}
	
	public function addField(Field $field) {
		$this->data[] = $field;
	}
	
	public function removeField(Field $field) {
		$key = array_search($field, $this->data);
		if($key) {
			unset($this->data[$key]);
		}		
	}
	
	public function find($name, $qualifier = null, $scheme = null) {
		return array_filter($this->data, function(Field $field) use ($name, $qualifier, $scheme) {
			if($field->getName() !== $name) {
				return false;
			}
			if($qualifier && $field->getQualifier() !== $qualifier) {
				return false;
			}
			if($scheme && $field->getScheme() !== $scheme) {
				return false;
			}
			return true;
		});
	}
	
	public function current() {
		if($this->valid()) {
			return $this->data[$this->position];
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
		return $this->position < count($this->data);
	}

}
