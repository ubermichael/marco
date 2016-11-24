<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Nines\Marco\Transform;

use Nines\Marco\Record\Record as MarcRecord;
use Nines\Marco\DublinCore\Field as DcField;

/**
 * Description of QualifiedDublinCore
 *
 * @author Michael Joyce <mjoyce@sfu.ca>
 */
class QualifiedDublinCore {

    private function values(array $fields) {
        return array_map(function(Field $field) {
            return $field->getValue();
        }, $fields);
    }

    public function accrualMethod(MarcRecord $record) {
        $fields = $record->getField('541', null, null, 'c');
        $dcFields = array();
        foreach ($fields as $f) {
            $dc = new DcField();
            $dc->setElement('accrualMethod');
            $dc->setValue($f->getValue());
            $dcFields[] = $dc;
        }
        return $dcFields;
    }

    public function accrualPeriodicity(MarcRecord $record) {
        $fields = $record->getField('310', null, null, 'a');
        $dcFields = array();
        foreach ($fields as $f) {
            $dc = new DcField();
            $dc->setElement('accrualPeriodicity');
            $dc->setValue($f->getValue());
            $dcFields[] = $dc;
        }
        return $dcFields;
    }

    public function audience(MarcRecord $record) {
        $fields = $record->getField('510');
        $dcFields = array();
        foreach ($fields as $f) {
            $dc = new DcField();
            $dc->setElement('audience');
            $dc->setValue($f->getValue());
            $dcFields[] = $dc;
        }
        return $dcFields;
    }

}
