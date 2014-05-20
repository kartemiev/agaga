<?php
namespace PbxAgi\RecordedCall\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use PbxAgi\Cdr\Model\CdrTableInterface;
use PbxAgi\RecordedCall\Model\RecordedCallTableInterface;
use Zend\Db\Sql\Where;
use Zend\Console\Prompt\Select;

class RecordedCallTable implements RecordedCallTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function fetchRecorded()
    {
    	$filter = new Where();
    	$filter->notEqualTo('recordedname', '');
    	$orderseq  = 'calldate ASC';
     	$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$orderseq) {
         $select->where($filter);     
       $select->order($orderseq);
     });
            $resultSet->buffer();

    	return $resultSet;
    }
    
    
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
