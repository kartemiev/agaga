<?php
namespace Maintainer\Cdr\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Expression;

class CdrTable implements CdrTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    public function beginTransaction()
    {
        $connection =  $this->getTableGateway()
                                ->getAdapter()
                                ->getDriver()
                                ->getConnection();
        $connection->beginTransaction();
    }
    public function commit()
    {
        $connection =  $this->getTableGateway()
                                ->getAdapter()
                                ->getDriver()
                                ->getConnection();
        $connection->commit();
    }
    public function fetchAll($filter = null, $orderseq = null)
    {
     	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter, $orderseq) {
               $select->where($filter);     
               $select->order($orderseq);
            });
            $resultSet->buffer();
    	return $resultSet;
    }
    
    public function getCdr($id)
    {
    	$id  = (int) $id;
    	$rowset = $this->tableGateway->select(array('id' => $id));
    	$row = $rowset->current();
    	if (!$row) {
    		throw new \Exception("Could not find row $id");
    	}
     	return $row;
    } 
    
public function saveCdr(Cdr $cdr)
    {        
    	$data = array(
    		'calldate' => $cdr->calldate,
    		'clid' => $cdr->clid,
    	    'src' => $cdr->src,
    	    'dst' => $cdr->dst,
    	    'dcontext' => $cdr->dcontext,
    	    'channel' => $cdr->channel,
    	    'dstchannel' => $cdr->dstchannel,
    	    'lastapp' => $cdr->lastapp,
    	    'lastdata' => $cdr->lastdata,
    	    'duration' => $cdr->duration,
    	    'billsec' => $cdr->billsec,
    	    'disposition' => $cdr->disposition,
    	    'accountcode' => $cdr->accountcode,
    	    'userfield' => $cdr->userfield,
    	    'uniqueid' => $cdr->uniqueid,
    	    'peeraccount' => $cdr->peeraccount,
    	    'linkedid' => $cdr->linkedid,
    	    'sequence' => $cdr->sequence,
    	    'transferred_from' => $cdr->transferred_from,
    	    'amaflags' => $cdr->amaflags,
    	    'test' => $cdr->test,
    	    'srcname' => $cdr->srcname,
    	    'dstname' => $cdr->dstname,
    	    'calleridname' => $cdr->calleridname,
    	    'operatorstatus' => $cdr->operatorstatus,
    	    'backupdate' => $cdr->backupdate    	    	
        	);
     
     	$id = (int)$cdr->id;
    	  
    	if ($this->getCdr($id)) {
    			$this->tableGateway->update($data, array('id' => $id));
    	} else {
    			throw new \Exception('Cdr id does not exist');
        }
    	
    }
    public function updateBackupDateOnly($id)
    {       
        $backupdate = date('Y-m-d H:i:s');
        $data = array('backupdate'=>$backupdate);
        $this->tableGateway->update($data, array('id' => $id));
    }
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
