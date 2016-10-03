<?php

namespace Nines\Marco;

use Exception;
use Iterator;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class File implements Iterator {
	
	private $path;
	
	private $handle;
	
	private $record;
	
	private $offset;
	
	public function __construct() {
		$this->path = null;
		$this->handle = null;
		$this->record = null;
	}
	
	public function open($path) {
		$this->path = $path;
		$this->handle = @fopen($path, 'r');
		if ($this->handle === false) {
			$error = error_get_last(); // "type", * "message", "file" and "line"
			throw new Exception("Cannot open {$path}: {$error['message']}");
		}
		$this->record = null;
		$this->offset = 0;
	}
	
	private function read() {
		if($this->handle === null) {
			return;
		}
		$length = fread($this->handle, 5);
		$content = fread($this->handle, $length - 5);		
		$this->record = new Record($length . $content);
		$this->offset++;
	}
	
	public function current() {
		if($this->record === null) {
			$this->read();
		}
		return $this->record;
	}

	public function key() {
		return $this->key - 1;
	}

	public function next() {
		$this->read();
	}

	public function rewind() {
		fseek($this->handle, 0);
	}

	public function valid() {
		return $this->handle !== null && !feof($this->handle);
	}

}
