<?php

namespace Nines\Marco\Record;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Content
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Content implements LoggerAwareInterface {

	/**
	 * @var LoggerInterface
	 */
	private $logger;
	
	private $content;
	
	private $entries;
	
	public function __construct() {
		$this->logger = new NullLogger();
	}

	public function read($content, Directory $directory) {
		$this->content = $content;
		foreach($directory->getEntries() as $entry) {
			$data = substr($content, $entry['start'], $entry['length'] - 1);
			$field = new Field();
			$field->read($data, $entry['field']);
			$this->entries[] = $field;
		}
	}
	
	public function setLogger(LoggerInterface $logger) {
		$this->logger = $logger;
	}	
	
}
