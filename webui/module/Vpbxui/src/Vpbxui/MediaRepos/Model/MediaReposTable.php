<?php
namespace Vpbxui\MediaRepos\Model;

use Vpbxui\MediaRepos\Model\MediaRepos;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Vpbxui\MediaRepos\Model\MediaReposTableInterface;

class MediaReposTable implements  MediaReposTableInterface
{

    protected $tableGateway;
    protected $vpbxid;
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
    
    
    public function getMediaReposById($id, $vpbxid)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    }
    
   
    
    public function saveMediaRepos(MediaRepos $mediarepos)
    {        
    	$data = array(
     	    'vpbxid' => $mediarepos->vpbxid,
    	    'custname' =>$mediarepos->custname,
    	    'custdesc' =>$mediarepos->custdesc,
    	    'contenttype' =>$mediarepos->contenttype,
    	    'filesize' =>$mediarepos->filesize,
    	    'mediatype' =>$mediarepos->mediatype,
    	    'duration' =>$mediarepos->duration,   	
    	    'extension' =>$mediarepos->extension    	        	
     	);
    	$id = (int)$mediarepos->id;
    	$vpbxid  = (int)$mediarepos->vpbxid;
    	if ($id == 0) {
    		$this->tableGateway->insert($data);
    		$return = $this->tableGateway->getLastInsertValue();
    	} else {
    		if ($this->getMediaReposById($id, $mediarepos->vpbxid)) {
    			$this->tableGateway->update($data, array('id' => $id, 'vpbxid'=>$mediarepos->vpbxid));
    		} else {
    			throw new \Exception('Form id does not exist');
    		}
    	}
    	return (isset($return))?$return:null;
    }
    
    public function deleteMediaRepos($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}