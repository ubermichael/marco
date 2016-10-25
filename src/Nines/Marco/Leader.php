<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco;

use Exception;

/**
 * Description of Leader
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Leader {
	
	const LEADER_BYTES = 24;
	
	private $data;
	
	public function __construct($data) {
        $this->data = substr($data, 0, self::LEADER_BYTES);
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function getLength() {
		return intval(substr($this->data, 0, 5));
	}
	
	public function getStatus() {
		return $this->data[5];
	}
	
	public function getType() {
		return $this->data[6];
	}
	
	public function getBibliographicLevel() {
		return $this->data[7];
	}
	
	public function getControl() {
		return $this->data[8];
	}
	
	public function getScheme() {
		return $this->data[9];
	}
	
	public function getIndCount() {
		return $this->data[10];
	}
	
	public function getSubFieldCount() {
		return $this->data[11];
	}
	
	public function getBaseAddress() {
		return intval(substr($this->data, 12, 5));
	}
	
	public function getEncodingLevel() {
		return $this->data[17];
	}
	
	public function getCatalogingForm() {
		return $this->data[18];
	}
	
	public function getRecordLevel() {
		return $this->data[19];
	}
	
	public function getLengthOfLength() {
		return $this->data[20];
	}
	
	public function getLengthOfStart() {
		return $this->data[21];
	}
	
	public function getLengthOfImplDefined() {
		return $this->data[22];
	}
	
	public function __toString() {
		return "=LDR       " . $this->data;
	}
    

}
