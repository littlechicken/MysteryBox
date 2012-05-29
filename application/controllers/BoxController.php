<?php

class BoxController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $box = new Application_Model_BoxMapper();
        $this->view->entries = $box->fetchAll();
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Box();
 
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($request->getPost())) {
                $comment = new Application_Model_Box($form->getValues());
                $mapper  = new Application_Model_BoxMapper();
                $mapper->save($comment);
                return $this->_helper->redirector('index');
            } else {
            	echo '<pre>'; print_r($form->getMessages()); echo '</pre>'; exit();
            }
        }
 
        $this->view->form = $form;
    }


}



