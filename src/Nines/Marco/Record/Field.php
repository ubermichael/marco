<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco\Record;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Description of Field
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Field {
	
	private $data;
	
	private $code;
	
	public function __construct($code, $data) {
		$this->code = $code;
		$this->data = $data;
	}
	
	public function getSubfields() {
		$matches = array();
		preg_match('/\x1f([a-z0-9 ])/u', $this->data, $matches);
		return array_slice($matches, 1);
	}
	
	public function getInd1() {
		return $this->data[0];
	}
	
	public function getInd2() {
		return $this->data[1];
	}
	
	public function getSubfield($n) {
		$matches = array();
		if(preg_match("/\x1f$n([^\x1f]*)\x1f/", $this->data, $matches)) {
			return $matches[1];
		} else {
			return null;
		}
	}
	
	public function isControl() {
		return substr($this->code, 0, 2) === '00';
	}
	
	public function __toString() {
		if($this->isControl()) {
			return sprintf("%s      %s\n", $this->code, $this->data);
		}
		$s = "";
		foreach($this->getSubfields() as $n) {
			$s .= sprintf("%s/%s%s$%s:%s\n", 
				$this->code,
				$this->getInd1(),
				$this->getInd2(),
				$n,
				$this->getSubfield($n)
			);
		}
		return $s;
	}
	
}
