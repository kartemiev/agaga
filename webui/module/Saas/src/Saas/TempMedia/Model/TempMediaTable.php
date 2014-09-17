<?php
namespace Saas\TempMedia\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
 
class TempMediaTable implements TempMediaTableInterface
{

    protected $tableGateway;
     public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchAll($filter=null)
    {
    	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter){
            $select->order('id');
            $select->where($filter);
        });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    
    public function getDefaultGreetings()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->where(array('accesslevel'=>'global'));
        });
        $resultSet->buffer();
        
        return $resultSet;
        
    }
    
    public function getTempMediaById($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveTempMedia(TempMedia $tempmedia)
    {        
    	$data = array(
    	    'custname' =>$tempmedia->custname,
    	    'custdesc' =>$tempmedia->custdesc,
    	    'contenttype' =>$tempmedia->contenttype,
    	    'filesize' =>$tempmedia->filesize,
    	    'mediatype' =>$tempmedia->mediatype,
    	    'accesslevel'=>$tempmedia->accesslevel
      	);
    	$id = (int)$tempmedia->id;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getTempMediaById($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteTempMedia($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}