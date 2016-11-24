<?php

namespace Nines\Marco\Record;

class Field {

<<<<<<< HEAD
	private $code;
	
	private $i1;
	
	private $i2;
	
	private $data;
	
	public function __construct() {
		$this->i1 = ' ';
		$this->i2 = ' ';
	}

	public function getCode() {
		return $this->code;
	}

	public function getI1() {
		return $this->i1;
	}

	public function getI2() {
		return $this->i2;
	}

	public function getData() {
		return $this->data;
	}

	public function setCode($code) {
		$this->code = $code;
		return $this;
	}

	public function setI1($i1) {
		$this->i1 = $i1;
		return $this;
	}

	public function setI2($i2) {
		$this->i2 = $i2;
		return $this;
	}

	public function setData($data) {
		$this->data = $data;
		return $this;
	}

	public function isControl() {
		return substr($this->code, 0, 2) === '00';
	}
	
	public function getSubfield($c) {
		if(array_key_exists($c, $this->data)) {
			return $this->data[$c];
		} 
		return null;
	}
		
	public function setSubfield($c, $v) {
		if($this->isControl()) {
			throw new Exception("Control fields do not have subfields.");
		}
		$this->data[$c] = $v;
	}
	
	/**
	 * Gets the value of a field, including all subfields.
	 */
	public function getValue($separator = ' ') {
		if( ! is_array($this->data)) {
			return $this->data;
		}
		return implode($separator, array_values($this->data));
	}
	
	public function __toString() {
		$str = "={$this->getCode()} {$this->getI1()}{$this->getI2()} ";
		if($this->isControl()) {
			$str .= "    " . $this->data;
			return $str;
		}
		$first = true;
		foreach($this->data as $k => $v) {
			$d = wordwrap($v, 65, "\n            ", true);
			if($first) {
				$first = false;
				$str .= " $${k} $d";
			} else {
				$str .= "\n         $${k} $d";
			}
		}
		return $str;
	}
	
=======
    private $code;
    private $i1;
    private $i2;
    private $data;

    public function __construct() {
        $this->i1 = ' ';
        $this->i2 = ' ';
    }

    public function getCode() {
        return $this->code;
    }

    public function getI1() {
        return $this->i1;
    }

    public function getI2() {
        return $this->i2;
    }

    public function getData() {
        return $this->data;
    }

    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    public function setI1($i1) {
        $this->i1 = $i1;
        return $this;
    }

    public function setI2($i2) {
        $this->i2 = $i2;
        return $this;
    }

    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function isControl() {
        return substr($this->code, 0, 2) === '00';
    }

    public function getSubfield($c) {
        if (array_keys($this->data, $c)) {
            return $this->data[$c];
        }
        return null;
    }

    public function setSubfield($c, $v) {
        if ($this->isControl()) {
            throw new Exception("Control fields do not have subfields.");
        }
        $this->data[$c] = $v;
    }

    public function __toString() {
        $str = "={$this->getCode()} {$this->getI1()}{$this->getI2()}";
        if ($this->isControl()) {
            $str .= "    " . $this->data;
            return $str;
        }
        $first = true;
        foreach ($this->data as $k => $v) {
            $d = wordwrap($v, 65, "\n           ", true);
            if ($first) {
                $first = false;
                $str .= " $${k} $d";
            } else {
                $str .= "\n        $${k} $d";
            }
        }
        return $str;
    }

>>>>>>> 38c6c68fec5dabd21e87d9a45495fde82f16d219
}
