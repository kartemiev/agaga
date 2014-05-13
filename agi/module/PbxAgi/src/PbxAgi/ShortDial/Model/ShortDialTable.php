<?php
namespace PbxAgi\ShortDial\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
  

class ShortDialTable 
    {
    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }
    public function getShortDialById($id)
    {
        $id = (int)$id;
        $rowset = $this->tableGateway->select(array('id'=>$id)); 
        return $rowset;
    }    
    public function getShortDialByShort($short, $peerid)
    {
        $rowset = $this->tableGateway->select(array('short'=>$short,'peerid'=>$peerid));   
        return $rowset;
    }
    public function fetchAll($filter=null, $limit = null)
    {
        $rowset = $this->tableGateway->select(function(Select $select) use ($filter,$limit) {
            $select->where($filter);
            $select->limit($limit);
        });
        return $rowset;
    }
    public function saveShortDial(ShortDial $shortdial)
    {    
        $data = array(
         'peerid' => $shortdial->peerid,            
         'number' => $shortdial->number,
         'short' => $shortdial->short,
          );
        
        if (isset($data['id']))
        {
        	$data['id'] = $shortdial->id;
        }
          if (isset($shortdial->id))
        {
            $id = (int)$shortdial->id;            
            $this->tableGateway->update($data,array('id' => $id));                        
           // $lastId = $id;
        } else 
        {
            $this->tableGateway->insert($data);            
           // $lastId = $this->tableGateway->getAdapter()
           // ->getLastGeneratedValue();
        }
        
        return (isset($lastId))?$lastId:null;
    }  
     public function deleteShortDial($id)
    {
    	$this->tableGateway->delete(array('id' => $id));
    }
}