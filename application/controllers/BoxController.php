<?php

class BoxController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $box = new Application_Model_BoxMapper();
        $this->view->entries = $box->fetchAll();
    }

    public function processFiles()
    {
    	try
    	{    		 
    		$apt    = new Zend_File_Transfer_Adapter_Http();
    		$files  = $apt->getFileInfo();
    		foreach($files as $file => $fileInfo) {
    			if ($apt->isUploaded($file)) {
    				if ($apt->isValid($file)) {
    					if ($apt->receive($file)) {
    						$info = $apt->getFileInfo($file);
    						$tmp  = $info[$file]['tmp_name'];
    						$data = file_get_contents($tmp);

    						/*$test_data = "<box> 
    										<deviceId>000123</deviceId>
    										<messageTitle>The title</messageTitle>
    										<messageBody>The body</messageBody>
    										<riddleQuestion>The question</riddleQuestion>
    										<riddleAnswer>The answer</riddleAnswer>
    										<unlockDate>20-06-1985 17:21:15</unlockDate>
    										<file name='test.file'>asfdsafqete</file>
    									  </box>";*/
    						    						
    						$box	= new Application_Model_Box();
    						$box->parseXml($data);
    						
    						$mapper  = new Application_Model_BoxMapper();
    						$mapper->save($box);
    					}
    				}
    			}
    		}
    	}  catch (Exception $ex) {
    		echo $ex->getMessage();
    	}
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_BoxAdd();
 
        if ($this->getRequest()->isPost()) {
            	$this->processFiles();
	            
            	echo 'file was uploaded';            	            	
                
                //return $this->_helper->redirector('index');
        }
 
        $this->view->form = $form;
    }

    public function changeAction()
    {
    	/*
    	if ($form->isValid($request->getPost())) {    	       
	    	$comment = new Application_Model_Box($form->getValues());
	    	$mapper  = new Application_Model_BoxMapper();
	    	$mapper->save($comment);
    	} else {
    		echo 'invalid form';
    		echo '<pre>'; print_r($form->getMessages()); echo '</pre>'; exit();
    	}
    	*/
    }

    public function showAction()
    {
		$id = $this->getRequest()->getParam('id');
		if ($id != -1) {
			$map = new Application_Model_BoxMapper();
			$box = new Application_Model_Box();
			
			$map->find($id, $box);
			$this->view->entry = $box;
		}
    }


}







