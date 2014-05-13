<?php
namespace PbxAgi\Conference\Model;

use Zend\Db\TableGateway\TableGateway;
use PbxAgi\Conference\Model\ConferenceTableInterface;
use Zend\Db\Sql\Select;
  
class ConferenceTable implements ConferenceTableInterface
{

    const CONF_EXPIRY_SQL_FILTER = 'datesettoexpiry>NOW()';
    
    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }

    public function getConferenceByConfNumber($confnumber)
    {
         $rowset = $this->tableGateway->select( function(Select $select) use ($confnumber) {
            $select->where(array('confnumber' => $confnumber));
           $select->where($this->getFilter());
            $select->limit(1);
        }
         );
 
          
         return $rowset;
    }    
    public function getConferenceById($id)
    {
        $rowset = $this->tableGateway->select( function(Select $select) use ($id) {
            $select->where(array('id' => $id));
            $select->where($this->getFilter());            
            $select->limit(1);
         }
            );
            if ($rowset)
            {
                $row = $rowset->current();
            }
            $result = ($row)?$row:null;
            return $result;
    }
    public function saveConference(Conference $conference)
    {        
    	$data = array(            
      	    'isprotected' => $conference->isprotected,
    	    'pin' => $conference->pin,
    	    'lastentered' => $conference->lastentered,
    	    'ownerref' => $conference->ownerref
       	);
    	$id = $conference->id;
    	    	 
    	if (NULL==!$conference->confnumber)
    	{
    	    $data['confnumber'] = $conference->confnumber;    	        	
    	}
    	if ($id)
    	{
     	  $this->tableGateway->update($data, array('id' => $id));
     	  $result = null;
    	}
    	else 
    	{
    	   $this->tableGateway->insert($data); 
    	  $result = $this->tableGateway->getLastInsertValue();
    	}
    	return $result;
    }    
      
    public function isValid($confnum)
    {
        $rowset =$this->getConferenceByConfNumber($confnum);
        
        return  ($rowset->count()>0);
    }
    protected function getFilter()
    {
       return self::CONF_EXPIRY_SQL_FILTER;       
    }
}