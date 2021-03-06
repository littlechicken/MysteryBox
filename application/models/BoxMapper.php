<?php
class Application_Model_BoxMapper
{
    protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Boxes');
        }
        return $this->_dbTable;
    }
 
    private function saveToAmazon(Application_Model_Box $box, $data) {
    	try
    	{
	    	$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/cloud.ini', 'amazon');
	    	$s3 = new Zend_Service_Amazon_S3($config->accessKey, $config->secretKey);
	    	$rootBucket = $config->rootBucket;
	    
	    	if (!$s3->isBucketAvailable($rootBucket));
	    	$s3->createBucket($rootBucket);
	    	
	    	$permissions = array(Zend_Service_Amazon_S3::S3_ACL_HEADER => Zend_Service_Amazon_S3::S3_ACL_PUBLIC_READ);
	    	$amazonFilePath = $rootBucket . DIRECTORY_SEPARATOR . $box->getAmazonFileName();
	    	
	    	$s3->putObject($amazonFilePath, $data, $permissions);
    	} catch(Exception $ex) {
    		print_r($ex->getMessage());
    	}
    }
       
    public function save(Application_Model_Box $box)
    {
    	//$data = $box->getFileContent();
    	$data = pack("H*", $box->getFileContent());
    	//$data = base64_decode($box->getFileContent());
    	
    	$this->saveToAmazon($box, $data);
		
        $data = array(
        	'boxId'	=> $box->getId(),
            'deviceId'   => $box->getDeviceId(),
            'messageTitle' => $box->getMessageTitle(),
        	'messageBody' => $box->getMessageBody(),
        	'riddleQuestion' => $box->getRiddleQuestion(),
        	'riddleAnswer' => $box->getRiddleAnswer(),
        	'fileName' => $box->getFileName(),
        	'fileType' => $this->getFileType($data),
        	'amazonFileName' => $box->getAmazonFileName(),        		
            'unlockDate' => $box->getDataBaseFormatUnlockDate(),
        );
 
        $this->getDbTable()->insert($data);
    }
    
    public function getFileType($data) {
    	$file_info = new finfo(FILEINFO_MIME);
    	$mime_type = $file_info->buffer($data);
    	return $mime_type;
    }
         
    public function find($id, Application_Model_Box $box)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $box->setId($row->boxId)
                  ->setDeviceId($row->deviceId)
                  ->setMessageTitle($row->messageTitle)
                  ->setMessageBody($row->messageBody)
                  ->setRiddleQuestion($row->riddleQuestion)
                  ->setRiddleAnswer($row->riddleAnswer)
                  ->setFileName($row->fileName)
                  ->setFileType($row->fileType)
                  ->setAmazonFileName($row->amazonFileName)
                  ->setUnlockDate($row->unlockDate);        
    }
 
    public function fetchAll()
    {
        $resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Application_Model_Box();
            $entry->setId($row->boxId)
                  ->setDeviceId($row->deviceId)
                  ->setMessageTitle($row->messageTitle)
                  ->setMessageBody($row->messageBody)
                  ->setRiddleQuestion($row->riddleQuestion)
                  ->setRiddleAnswer($row->riddleAnswer)
                  ->setFileName($row->fileName)
                  ->setFileType($row->fileType)
                  ->setAmazonFileName($row->amazonFileName)                  
                  ->setUnlockDate($row->unlockDate);        
            $entries[] = $entry;
        }
        return $entries;
    }
    
    public function delete($boxId) {
    	$table = $this->getDbTable();
    	
    	$where = $table->getAdapter()->quoteInto('boxId = ?', $boxId);
    	
    	$table->delete($where);
    }
}