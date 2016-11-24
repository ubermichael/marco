<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco\Transform;

use Nines\DublinCore\Field as DcField;
use Nines\DublinCore\Record as DcRecord;
use Nines\Marco\Record\Field;
use Nines\Marco\Record\Record;

/**
 * Description of QualifiedDublinCore
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class DublinCoreCrosswalk {
    private $properties = array(
        'contributor', 'coverage', 'creator', 'date', 'description',
        'format', 'identifier', 'language', 'publisher', 'relation',
        'rights', 'source', 'subject', 'title', 'type',
    );
    
    private function values(array $fields) {
        return array_map(function(Field $field) {
            return $field->getValue();
        }, $fields);
    }

    public function contributor(Record $record) {
        return $this->values($record->findField([100,110,111,700,710,711,720]));
    }

    public function coverage(Record $record) {
        return $this->values($record->findField([651,662,751,752]));
    }

    public function creator(Record $record) {
        return array();
    }

    public function date(Record $record) {
		$dates = array();
		$dateCtrls = $record->findField('008'); // Can't be 8 or 008.
		foreach($dateCtrls as $d) {
			$dates[] = substr($d->getValue(), 7, 4);
		}
		
		$dateFields = $record->findField(260);
		foreach($dateFields as $df) {
			if(($c = $df->getSubfield('c')) !== null) {
				$dates[] = $c;
			}
			if(($g = $df->getSubfield('g')) !== null) {
				$dates[] = $g;
			}
		}
		return $dates;
    }

    public function description(Record $record) {
		$descriptions = [];
		$fields = $record->getFields();
		foreach($fields as $field) {
			$code = $field->getCode();
			if(($code < 500) || ($code > 599) || in_array($code, [506,530,540,546])) {
				continue;
			}
			$descriptions[] = $field->getValue();
		}
		return $descriptions;
    }

    public function format(Record $record) {		
		$formats = $this->values($record->findField(340));
		
		foreach($record->findField(300) as $f) {
			if(($a = $f->getSubfield('a')) !== null) {
				$formats[] = $a;
			}
		}		
		
		foreach($record->findField(533) as $f) {
			if(($e = $f->getSubfield('e')) !== null) {
				$formats[] = $e;
			}
		}
		
		foreach($record->findField(856) as $f) {
			if(($q = $f->getSubfield('q')) !== null) {
				$formats[] = $q;
			}
		}
		
		return $formats;
    }

    public function identifier(Record $record) {
		$ids = [];
		foreach($record->findField(['020', '022', '024']) as $field) {
			if(($a = $field->getSubfield('a')) !== null) {
				$ids[] = $a;
			}
		}
		
		foreach($record->findField(856) as $field) {
			if(($u = $field->getSubfield('u')) !== null) {
				$ids[] = $u;
			}
		}
		return $ids;		
    }

    public function language(Record $record) {
        $lang = [];
		
        $langs = $record->findField('008');
        if(count($langs)) {
            $lang[] = substr($langs[0]->getValue(), 35, 3);
        }
		
		foreach($record->findField('041') as $field) {
			foreach(['a', 'b', 'd', 'e', 'f', 'g', 'h', 'j'] as $subcode) {
				if(($sc = $field->getSubfield($subcode)) !== null) {
					$lang[] = $sc;
				}
			}
		}
		
		return array_merge($lang, $this->values($record->findField(546)));
    }

    public function publisher(Record $record) {
		$publishers = [];
		foreach($record->findField(260) as $field) {
			$p = [];
			if(($a = $field->getSubfield('a')) !== null) {
				$p[] = $a;
			}
			if(($b = $field->getSubfield('b')) !== null) {
				$p[] = $b;
			}
			if(count($p) > 0) {
				$publishers[] = implode(' ', $p);
			}
		}
		return $publishers;
    }

    public function relation(Record $record) {
		$relations = [];
		foreach($record->findField('530') as $field) {
			$relations[] = $field->getValue();
		}
		
		foreach($record->getFields() as $field) {
			$code = $field->getCode();
			if(($code < 760) || ($code > 787)) {
				continue;
			}
			$r = [];
			if(($o = $field->getSubcode('o')) !== null) {
				$r[] = $o;
			}
			if(($t = $field->getSubcode('t')) !== null) {
				$r[] = $t;
			}
			if(count($r) > 0) {
				$relations[] = implode(' ', $r);
			}
		}
		return $relations;
    }

    public function rights(Record $record) {
        return $this->values($record->findField([506,540]));
    }

    public function source(Record $record) {
		$sources = [];
		foreach($record->findField(534) as $field) {
			if(($t = $field->getSubfield('t')) !== null) {
				$sources[] = $t;
			}
		}
		foreach($record->findField(786) as $field) {
			$s = [];
			if(($o = $field->getSubfield('o')) !== null) {
				$s[] = $o;
			}
			if(($t = $field->getSubfield('t')) !== null) {
				$s[] = $t;
			}
			if(count($s) > 0) {
				$sources[] = implode(' ', $s);
			}
		}
		return $sources;
    }

    public function subject(Record $record) {
		$codes = array('050','060','080','082',600,610,611,630,650,653);
		return $this->values($record->findField($codes));
    }

    public function title(Record $record) {
		$codes = array(245,246,210,222,240,242,243,247);
		return $this->values($record->findField($codes));
    }

    public function type(Record $record) {
		$values = [];
		foreach($record->findField('655') as $field) {
			if(($a = $field->getSubfield('a')) !== null) {
				$values[] = $a;
			}
		}
        switch($record->getLeader()->getType()) {
            case 'a':
            case 'c':
            case 'd':
            case 't':
                $values[] = 'text';
                break;
            case 'e':
            case 'f':
            case 'g':
            case 'k':
                $values[] = 'image';
                break;
            case 'i':
            case 'j':
                $values[] = 'sound';
                break;
            case 'm':
            case 'o':
            case 'p':
            case 'r':
                $values[] = 'no type provided';
                break;
            case 'p':
                $values[] = 'collection';
                break;
        }
        switch($record->getLeader()->getBibliographicLevel()) {
            case 'c': 
            case 's':
                $values[] = 'collection';
                break;
        }
        return $values;
    }

    public function dc(Record $record) {
		$dc = [];
		
        foreach($this->properties as $name) {
			$dc['dc.' . $name] = $this->$name($record);
        }
		return $dc;
    }
}
