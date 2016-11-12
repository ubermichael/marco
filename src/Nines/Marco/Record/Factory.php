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
		$record->setDirectory(new Directory($data, $record->getLeader()));
		$record->setFieldset(new FieldSet($data, $record->getLeader(), $record->getDirectory()));
		return $record;
	}
	
}
