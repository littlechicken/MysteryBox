<?php

class Application_Model_ViewerMapper
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
			$this->setDbTable('Application_Model_DbTable_Viewers');
		}
		return $this->_dbTable;
	}
	
	public function save(Application_Model_Viewer $v)
	{	
		$data = array(
				'viewerId'   => $v->getId(),
				'boxId' => $v->getBoxId(),
				'isViewed' => $v->getIsViewed(),
		);
	
		$this->getDbTable()->insert($data);
	}
	
	public function find($id, Application_Model_Viewer $v)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		$v->setId($row->viewerId)
		  ->setBoxId($row->boxId)
		  ->setIsViewed($row->isViewed);
	}
	
	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Viewer();
			$entry->setId($row->viewerId)
				  ->setBoxId($row->boxId)
			      ->setIsViewed($row->isViewed);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function fetchByBoxId($boxId) {
		$table = $this->getDbTable();
		$rows = $table->fetchAll($table->select()->where('boxId = ?', $boxId));
		$entries   = array();
		foreach ($rows as $row) {
			$entry = new Application_Model_Viewer();
			$entry->setId($row->viewerId)
			->setBoxId($row->boxId)
			->setIsViewed($row->isViewed);
			$entries[] = $entry;
		}
		return $entries;
	}

	public function delete($viewerId) {
		$table = $this->getDbTable();
		 
		$where = $table->getAdapter()->quoteInto('viewerId = ?', $viewerId);
		 
		$table->delete($where);
	}	
}

