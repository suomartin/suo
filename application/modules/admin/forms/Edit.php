<?php

class Admin_Form_Edit extends Zend_Form
{
    public function createFormToEntity($s_entity_name, $o_entity)
    {
        $o_em = ServiceLocator::getEm();

        $o_metadata = $o_em->getClassMetadata($s_entity_name);

        foreach ($o_metadata->fieldMappings as $s_field_name => $a_field_data) {
            if ('id' == $s_field_name) {
                $this->createIdElementToEntity($a_field_data, $o_entity);
            } else {
                $this->createIdElementToEntity($a_field_data, $o_entity);
            }
        }

        $this->addElement('submit', 'submit_button', array('require' => false, 'label' => 'Применить'));

        $this->setMethod(Zend_Form::METHOD_POST);
    }

    protected function createDefaultElementToEntity($a_field_data, $o_entity)
    {
        return $this->addElement('text', $a_field_data['fieldName'], $o_entity->$a_field_data['fieldName']);
    }

    protected function createIdElementToEntity($a_field_dat, $o_entity)
    {
        return $this->addElement('hidden', 'id', array('value' => $o_entity->id));
    }
}
