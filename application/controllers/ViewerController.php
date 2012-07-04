<?php

class ViewerController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $request = $this->getRequest();
        $form    = new Application_Form_Viewer();
 
        /*$test_data = "<viewer>
						<viewerId>dsfasdfadsf1</viewerId>
    					<boxId>1a3138d6-6b8d-4648-b818-4cc8e4debf8c</boxId>
    					<isViewed>0</isViewed>
    				  </viewer>";
        
        $this->processData($test_data);*/
        
        if ($this->getRequest()->isPost()) {
            $this->processFiles();
	            
            echo 'file was uploaded';            	            	
        }
 
        $this->view->form = $form;
    }

    public function processData($data)
    {
    	$xml = simplexml_load_string($data);
    	
    	$viewer	= new Application_Model_Viewer();
    	$viewer->parseXml($xml);
    	
    	$mapper  = new Application_Model_ViewerMapper();
    	$mapper->save($viewer);
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

    public function showAction()
    {
    	//$id = $this->getRequest()->getParam('id');
		//if ($id != null && $id != -1) {
			$vmap = new Application_Model_ViewerMapper();
			$v = new Application_Model_Viewer();

			$map = new Application_Model_BoxMapper();
				
			$entries   = array();
			$viewers = $vmap->fetchAll();
			foreach($viewers as $viewer) {
				$box = new Application_Model_Box();
				$map->find($viewer->getBoxId(), $box);
				
				if ($box->isNotEmpty())
					$entries[] = $box;
			}
			
			$this->view->entries = $entries;
		//}
    }


}





