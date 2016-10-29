<?php

namespace Nines\Marco;

class Crosswalk {

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
        return $this->values($record->getField('(?:100|110|111|700|710|711|720)'));
    }

    public function coverage(Record $record) {
        return $this->values($record->getField('(?:651|662|751|752)'));
    }

    public function creator(Record $record) {
        return array();
    }

    public function date(Record $record) {
        $dates = $record->getField('008');
        $year = array();
        if(count($dates) > 0) {
            $year = array(substr($dates[0]->getValue(), 7, 4));
        }
        return array_merge(
            $year,
            $this->values($record->getField('260', null, null, '[cg]'))
        );
    }

    public function description(Record $record) {
        return $this->values(
            array_filter($record->getField('5..'), function(Field $field) {
                return !in_array($field->getCode(), array('506', '530', '540', '546'));
            })
        );
    }

    public function format(Record $record) {
        return $this->values(array_merge(
                $record->getField('340'),
                $record->getField('856', null, null, 'q')
        ));
    }

    public function identifier(Record $record) {
        return $this->values(array_merge(
                $record->getField('02[024]', null, null, 'a'),
                $record->getField('856', null, null, 'u')
        ));
    }

    public function language(Record $record) {
        $langs = $record->getField('008');
        $lang = array();
        if(count($langs)) {
            $lang = array(substr($langs[0], 35, 3));
        }
        return array_merge(
            $lang,
            $record->getField('041', null, null, '[abdefghj]'),
            $record->getField('546')
        );
    }

    public function publisher(Record $record) {
        return $this->values($record->getField('260', null, null, '[ab]'));
    }

    public function relation(Record $record) {
        $range = $record->getField('7[678].', null, null, '[ot]');
        $relations = array_filter($range, function(Field $field){
            return $field->getCode() <= 787;
        });
        return $this->values(array_merge(
                $relations,
                $record->getField('530')
        ));
    }

    public function rights(Record $record) {
        return $this->values($record->getField('(?:506|540)'));
    }

    public function source(Record $record) {
        return $this->values(array_merge(
                $record->getField('534', null, null, 't'),
                $record->getField('786', null, null, '[ot]')
        ));
    }

    public function subject(Record $record) {
        return $this->values(array_merge(
                $record->getField('(?:050|060|080|082)'),
                $record->getField('(?:600|610|611|630|650|653)')
        ));
    }

    public function title(Record $record) {
        return $this->values(
            $record->getField('(?:210|222|240|242|243|245|246|247)')
        );
    }

    public function type(Record $record) {
        $values = $this->values($record->getField('655'));
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
        $result = array();
        foreach($this->properties as $name) {
            $values = $this->$name($record);
            if(count($values) > 0) {
                $result[$name] = $values;
            }
        }
        return $result;
    }

}
