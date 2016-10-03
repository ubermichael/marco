<?php

namespace Nines\Marco\Record;

use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Description of Leader
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Leader {
	
	private $content;

	public function __construct($content) {
		if(strlen($content) !== 24) {
			throw new Exception("Expected 24 bytes for leader. Got " . strlen($content));
		}
		$this->content = $content;
	}
	
	public function getLength() {
		return intval(substr($this->content, 0, 5));
	}	
	
	public function getDataAddress() {
		return intval(substr($this->content, 12, 5));
	}
}
