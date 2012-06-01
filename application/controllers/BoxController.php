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
    						$this->processData($data);
    					}
    				}
    			}
    		}
    	}  catch (Exception $ex) {
    		echo $ex->getMessage();
    	}
    }

    public function processData($data) {
		$xml = simplexml_load_string($data);			
		$box	= new Application_Model_Box();
		
		$box->parseXml($xml);									
		$mapper  = new Application_Model_BoxMapper();
		$mapper->save($box);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_BoxAdd();
 
        /*$test_data = "<box>
         					<boxId>000125</boxId>
        					<deviceId>000123</deviceId>
        					<messageTitle>The title</messageTitle>
        					<messageBody>The body</messageBody>
        					<riddleQuestion>The question</riddleQuestion>
        					<riddleAnswer>The answer</riddleAnswer>
        					<unlockDate>20-06-1985 17:21:15</unlockDate>
        					<file name='test.file'>asfdsafqete</file>
        				</box>";
        $this->processData($test_data);*/
        
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
		/*$id = $this->getRequest()->getParam('id');
		if ($id != -1) {
			$map = new Application_Model_BoxMapper();
			$box = new Application_Model_Box();
			
			$map->find($id, $box);
			$this->view->entry = $box;
		}*/
    	
    	$boxId = $this->getRequest()->getParam('boxId');
    	$viewerId = $this->getRequest()->getParam('viewerId');
    	if ($boxId != null && $boxId != -1) {
    		$vmap = new Application_Model_ViewerMapper();
    			
    		$v = new Application_Model_Viewer();
    		$vmap->find($viewerId, $v);
    			
    		$box = new Application_Model_Box();
    		$map = new Application_Model_BoxMapper();
    		$map->find($v->getBoxId(), $box);
    			
    		$this->view->entry = $box;
    	}    	
    }


}







