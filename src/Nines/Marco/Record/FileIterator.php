<?php

namespace Nines\Marco\Record;

use Exception;
use Iterator;

/**
 * Description of Iterator
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class FileIterator implements Iterator {

    private $handle;
    private $path;
    private $record;
    private $offset;
	private $factory;

    public function __construct($path) {
        if (!file_exists($path)) {
            throw new Exception("Cannot open {$path}: File not found.");
        }
        if (!is_readable($path)) {
            throw new Exception("Cannot open {$path}: Path is not readable.");
        }
		$this->factory = new Factory();
        $this->record = null;
        $this->path = $path;
        $this->handle = @fopen($path, 'rb');
        $this->offset = 0;
        if ($this->handle === false) {
            $error = error_get_last();
            throw new Exception("Cannot read {$path}: {$error['message']}");
        }
    }

    private function read() {
        if ($this->handle === null) {
            return;
        }
        if (!$this->valid()) {
            $this->record = null;
            return;
        }
        $length = fread($this->handle, Record::LENGTH_BYTES);
        if (!$length) {
            $this->record = null;
            return;
        }
        $content = fread($this->handle, intval($length) - Record::LENGTH_BYTES);
        $this->record = $this->factory->build($length . $content);

        $this->offset++;
    }

    /**
     * @return Record
     */
    public function current() {
        if ($this->record === null) {
            $this->read();
        }
        return $this->record;
    }

    public function key() {
        return $this->offset - 1;
    }

    public function next() {
        $this->read();
    }

    public function rewind() {
        fseek($this->handle, 0);
        $this->offset = 0;
        $this->record = null;
    }

    public function valid() {
        return $this->handle !== null && !feof($this->handle);
    }

}
