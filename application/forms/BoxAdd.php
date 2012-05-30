<?php

class Application_Form_BoxAdd extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
 
        /*
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
        
        // Add the comment element
        $this->addElement('textarea', 'comment', array(
            'label'      => 'Please Comment:',
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 20))
                )
        ));
 */
        
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

