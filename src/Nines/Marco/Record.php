<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco;

use Exception;

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
	
	private $fields;
	
	private $data;
	
	public function __construct($data) {
		if(substr($data, -1) !== self::RECORD_TERMINATOR) {
			throw new Exception("Record should end with \\x1D. Found " . substr($data, -1));
		}
		$length = substr($data, 0, 5);
		if(strlen($data) !== intval($length)) {
			throw new Exception("Expected record length " . intval($length) . " does not match actual length " . strlen($data));
		}
		$this->data = $data;
		$this->leader = new Leader($data);
		$this->directory = new Directory($data, $this->leader);
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
	
	public function getFields() {
		$fields = array();
		$base = $this->leader->getBaseAddress();
		foreach($this->directory as $entry) {
			$fieldData = substr($this->data, $base + $entry->getStart(), $entry->getLength());
			if(substr($entry->getField(), 0, 2) === '00') {
				$fields[] = new Field($entry->getField() . '   ' . substr($fieldData, 0, -1));
				continue;
			}
			$fieldList = explode("\x1F", $fieldData);
			$fieldList[count($fieldList)-1] = substr($fieldList[count($fieldList)-1], 0, -1);
			for($i = 1; $i < count($fieldList); ++$i) {
				$fields[] = new Field($entry->getField() . substr($fieldData, 0, 2) . $fieldList[$i]);
			}
		}
		return $fields;
	}
	
}
