<?php
namespace PbxAgi\FaxSpoolLog\Model;

use Zend\Db\TableGateway\TableGateway;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLogTableInterface;
use PbxAgi\FaxSpoolLog\Model\FaxSpoolLog;

class FaxSpoolLogTable implements FaxSpoolLogTableInterface
{ 
    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }
    public function saveLogEntry(FaxSpoolLog $faxspoollog)
    {    
        $data = array(
         'spoolref' => $faxspoollog->spoolref,            
         'action' => $faxspoollog->action,
         'result' => $faxspoollog->result,
         'reason' => $faxspoollog->reason		
         );
        if (isset($faxspoollog->id))
        {
            $id = (int)$faxspoollog->id;
            $this->tableGateway->update($data,array('id' => $id));                        
        } else 
        {
            $this->tableGateway->insert($data);            
            $lastId = $this->tableGateway->getLastInsertValue();
        }
        
        return (isset($lastId))?$lastId:null;
    }  
    public function updateResult(FaxSpoolLog $faxspoollog)
    {
        $id = (int)$faxspoollog->id;
        if (NULL==$id)
        {
        	throw new \Exception('id to update not set!');
        }
        $data = array(
        		'result' => $faxspoollog->result,
        		'reason' => $faxspoollog->reason
        );        
        $this->tableGateway->update($data,array('id' => $id));        
    }
}