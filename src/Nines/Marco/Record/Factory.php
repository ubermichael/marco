<?php

namespace Nines\Marco\Record;

use Exception;

/**
 * Description of Factory
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class Factory {

    public function build($data) {
        if (substr($data, -1) !== Record::RECORD_TERMINATOR) {
            throw new Exception("Record should end with \\x1D. Found " . substr($data, -1));
        }
        $length = substr($data, 0, 5);
        if (strlen($data) !== intval($length)) {
            throw new Exception("Expected record length " . intval($length) . " does not match actual length " . strlen($data));
        }
        $record = new Record();
        $record->setData($data);
        $record->setleader(new Leader($data));
        $this->addFields($data, $record);
        return $record;
    }

    public function addFields($data, Record $record) {
        $base = $record->getLeader()->getBaseAddress();
        $dir = substr($data, Record::LEADER_BYTES, $base - Record::LEADER_BYTES);
        if (substr($dir, -1) !== Record::DIRECTORY_TERMINATOR) {
            throw new Exception("Directory should end with \\x1E. Found " . substr($dir, -1));
        }
        $offset = 0;
        while ($offset < strlen($dir) - 1) {
            list($code, $start, $length) = array(
                substr($data, Record::LEADER_BYTES + $offset, 3),
                substr($data, Record::LEADER_BYTES + $offset + 7, 5),
                substr($data, Record::LEADER_BYTES + $offset + 3, 4)
            );
            $record->addField($this->buildField(substr($data, $base + $start, intval($length)), $code));
            $offset += Record::ENTRY_LENGTH;
        }
    }

    public function buildField($data, $code) {
        if (substr($data, -1) !== Record::FIELD_TERMINATOR) {
            throw new Exception("Field should end with \\x1E. Found " . substr($data, -1));
        }
        $data = rtrim($data, Record::FIELD_TERMINATOR);
        $field = new Field();
        $field->setCode($code);
        if ($field->isControl()) {
            $field->setData($data);
            return $field;
        }

        $field->setI1($data[0]);
        $field->setI2($data[1]);
        $subfields = explode(Record::SUBFIELD_START, $data);
        foreach (array_slice($subfields, 1) as $subfield) {
            if( ! $subfield) {
                continue;
            }
            $subcode = $subfield[0];
            $data = substr($subfield, 1);
            $field->setSubfield($subcode, $data);
        }
        return $field;
    }

}
