<?php
namespace PbxAgi\FaxSpool\Model;

use Zend\Db\TableGateway\TableGateway;
use PbxAgi\FaxSpool\Model\FaxSpoolTableInterface;
use PbxAgi\FaxSpool\Model\FaxSpool;

class FaxSpoolTable implements FaxSpoolTableInterface
{ 
    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }
    public function saveFax(FaxSpool $fax)
    {    
        $data = array(
         'recordtype' => $fax->recordtype,            
         'uniqueid' => $fax->uniqueid,
         'faxstatus' => $fax->faxstatus,
         'pages' => $fax->pages,            
        );
        if (isset($fax->id))
        {
            $id = (int)$fax->id;
            $this->tableGateway->update($data,array('id' => $id));                        
        } else 
        {
            $this->tableGateway->insert($data);            
            $lastId = $this->tableGateway->getLastInsertValue();
        }
        
        return (isset($lastId))?$lastId:null;
    }  
}