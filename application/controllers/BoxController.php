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
    }

    public function processData($data)
    {
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
    	/*$test_data = "<changeBox>
    	 <oldBoxId>125</oldBoxId>
    	 <newBoxId>125</newBoxId>
    	</changeBox>";
    	 
    	$this->processChange($test_data);*/
    	    	
    	if ($this->getRequest()->isPost()) {
    		$this->processChangeQuery();
    	}
    	 
    	$this->view->form = $form;
    }

    public function processChangeQuery() {
    	$apt    = new Zend_File_Transfer_Adapter_Http();
    	$files  = $apt->getFileInfo();
    	foreach($files as $file => $fileInfo) {
    		if ($apt->isUploaded($file)) {
    			if ($apt->isValid($file)) {
    				if ($apt->receive($file)) {
    					$info = $apt->getFileInfo($file);
    					$tmp  = $info[$file]['tmp_name'];
    					$data = file_get_contents($tmp);
    					$this->processChange($data);
    				}
    			}
    		}
    	}
    
    }
    
    function processChange($data) {
    	$xml = simplexml_load_string($data);
    	$newbox = new Application_Model_Box();
    	
    	$newbox->parseXml($xml);
    	$map  = new Application_Model_BoxMapper();

    	$oldBoxId = (string)$xml->oldBoxId;

    	$oldbox = new Application_Model_Box();
    	$map->find($oldBoxId, $oldbox);

    	$box->copyOf($oldBox);
    	
    	$map->save($box);
    }
        
    public function showAction()
    {
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

    public function processRemoveQuery() {
    	$apt    = new Zend_File_Transfer_Adapter_Http();
    	$files  = $apt->getFileInfo();
    	foreach($files as $file => $fileInfo) {
    		if ($apt->isUploaded($file)) {
    			if ($apt->isValid($file)) {
    				if ($apt->receive($file)) {
    					$info = $apt->getFileInfo($file);
    					$tmp  = $info[$file]['tmp_name'];
    					$data = file_get_contents($tmp);
    					$this->processRemove($data);
    				}
    			}
    		}
    	}
    	 
    }

    function processRemove($data) {
    	$xml = simplexml_load_string($data);
    	$boxId = (string)$xml->boxId;
    
    	$box = new Application_Model_Box();
    	$map = new Application_Model_BoxMapper();
    	$map->find($boxId, $box);
    
    	if ($box->isNotNull()) {
    		$bmap = new Application_Model_BoxMapper();
    		$bmap->delete($boxId);
    		
    		$viewers = $vmap->fetchByBoxId($boxId);

    		$vmap = new Application_Model_ViewerMapper();
    		foreach($viewers as $viewer) {
    			$vmap->delete($viewer->getId());    			
    		}
    	}
    }
    
    public function deleteAction()
    {
    	/*$test_data = "<deleteBox>
    		<boxId>125</boxId>
    	</deleteBox>";
    	
    	$this->processRemove($test_data);*/
    	
    	if ($this->getRequest()->isPost()) {
    		$this->processRemoveQuery();    		    		 
    	}
    	
    	$this->view->form = $form;
    }


}









