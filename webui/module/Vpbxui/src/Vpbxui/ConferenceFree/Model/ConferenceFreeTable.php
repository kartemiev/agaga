<?php
namespace Vpbxui\ConferenceFree\Model;

use Zend\Db\TableGateway\TableGateway;
use Vpbxui\ConferenceFree\Model\ConferenceFreeTableInterface;
use Zend\Db\Sql\Select;
  
class ConferenceFreeTable implements ConferenceFreeTableInterface
{
 
    protected $tableGateway;

    public function __construct(TableGateway $tablegateway)
    {
        $this->tableGateway = $tablegateway;
    }

    public function fetchAll($filter = null, $limit = null)
    {
       return  $this->tableGateway->select(function(Select $select) use ($filter, $limit){
          if ($filter)
          {
              $select->where($filter);
          }
          $select->limit($limit);    
       }
       );
    }
    
}