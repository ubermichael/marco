<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco;

use Nines\Marco\Record\Directory;
use Nines\Marco\Record\Field;
use Nines\Marco\Record\Leader;

/**
 * Description of Record
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Record {
	
	private $leader;
	
	/**
	 * @var Field[]
	 */
	private $content;

	public function __construct($data) {
		$this->leader = new Leader(substr($data, 0, 24));		
		$baseAddr = $this->leader->getDataAddress();		
		$directory = new Directory($data, $baseAddr); 	
		foreach($directory as $entry) {
			$field = new Field(
				$entry->getField(), 
				substr($data, $baseAddr+$entry->getStart())
			);
			$this->content[] = $field;
		}
	}
	
	public function getContent() {
		return $this->content;
	}
	
	public function __toString() {
		$s = '';
		foreach($this->content as $field) {
			$s .= $field;
		}
		return $s;
	}
	
}
