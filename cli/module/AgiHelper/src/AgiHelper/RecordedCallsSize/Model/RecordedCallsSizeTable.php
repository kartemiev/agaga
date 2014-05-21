<?php
namespace AgiHelper\RecordedCallsSize\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Where;
use Zend\Console\Prompt\Select;
use AgiHelper\RecordedCallsSize\Model\RecordedCallsSizeTableInterface;

class RecordedCallsSizeTable implements RecordedCallsSizeTableInterface {

    protected $tableGateway;
    public function __construct(TableGateway $tableGateway)
    {
    	$this->tableGateway = $tableGateway;
    }
    
    public function getTotalSize()
    {
    	$resultSet = $this->tableGateway->select();
    	$totalsize = $resultSet->current();
    
    	return $totalsize;
    }
    
    
    public function getTableGateway()
    {
        return $this->tableGateway;
    }
}
