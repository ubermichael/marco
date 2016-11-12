<?php

namespace Nines\DublinCore;

/**
 * Description of Statement
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Field {
	
	private $element;
	
	private $qualifier;
	
	private $scheme;
	
	private $value;
	
	public function getElement() {
		return $this->element;
	}

	public function getQualifier() {
		return $this->qualifier;
	}
	
	public function hasQualifier() {
		return (bool)$this->qualifier;
	}

	public function getScheme() {
		return $this->scheme;
	}

	public function hasScheme() {
		return (bool)$this->scheme;
	}

	public function getValue() {
		return $this->value;
	}
	
	public function setElement($element) {
		$this->element = $element;
		return $this;
	}

	public function setQualifier($qualifier) {
		$this->qualifier = $qualifier;
		return $this;
	}

	public function setScheme($scheme) {
		$this->scheme = $scheme;
		return $this;
	}

	public function setValue($value) {
		$this->value = $value;
		return $this;
	}
	
	public function __toString() {
		$str = $this->element;
		if($this->qualifier) {
			$str .= '.' . $this->qualifier;
		}
		if($this->scheme) {
			$str .= '#' . $this->scheme;
		}
		$str .= ' ' . $this->value;
		return $str;
	}
	
}
