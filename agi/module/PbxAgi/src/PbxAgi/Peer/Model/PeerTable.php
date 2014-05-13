<?php
namespace PbxAgi\Peer\Model;

use Zend\Db\TableGateway\TableGateway;

class PeerTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }

    public function getPeer($name)
    {
         $rowset = $this->tableGateway->select(
                 array('name' => $name)
                 );
         $row = $rowset->current();
          if (!$row) {
            throw new \Exception("Could not find peer $name");
        }
        return $row;
    }
    public function getPeerByExtenNum($extenNum)
    {
        $rowset = $this->tableGateway->select(
            array('extension' => (int)$extenNum)
        );
        $row = $rowset->current();        
        return $row;
    }
}