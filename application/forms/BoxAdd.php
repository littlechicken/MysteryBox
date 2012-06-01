<?php

class Application_Form_BoxAdd extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
        
        // File upload
        $this->setAttrib('enctype', 'multipart/form-data');
                
        $element = new Zend_Form_Element_File('theFile');
        $element->setLabel('Add file:');
        $element->addValidator('Count', false, 1);
        $element->addValidator('Size', false, 102400);
        //$element->addValidator('Extension', false, '*');
        $validatorNotEmpty = new Zend_Validate_NotEmpty();
        $this->addElement($element, 'theFile', array(
        		'validators'  => array($validatorNotEmpty)
        ));
        
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Add to Box',
        ));
 
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }

}

