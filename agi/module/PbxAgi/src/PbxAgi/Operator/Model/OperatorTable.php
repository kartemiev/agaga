<?php
namespace PbxAgi\Operator\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGatewayInterface;
use PbxAgi\Operator\Model\OperatorTableInterface;
use PbxAgi\Operator\Model\OperatorInterface;

class OperatorTable implements OperatorTableInterface
{
    protected $tableGateway;
    public function __construct(TableGatewayInterface $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select("extensiontype='operator'", function (Select $select)
        {
            $select->order('extension ASC');
        });
        return $resultSet;
    }
    
    public function getOperator($extension)
    {
        $extension = $extension;
        $rowset = $this->tableGateway->select(array(
            'extension' => $extension
        ));
        $row = $rowset->current();
        if (! $row) {
            return null; // throw new Exception; // доделать по нормальному
        }
        return $row;
    }
    
   public function saveOperator(OperatorInterface $operator)
    {
     
    	$data = array(         
    	    'extension' => $operator->extension,
    	    	
             'extensiontype' => $operator->extensiontype,
            'name'  => $operator->name,
    	    'operatorstatus' => $operator->operatorstatus
     	);
    	$extension = $operator->extension;
     		if ($this->getOperator($extension)) {
    			$this->tableGateway->update($data, array('extension' => $extension));
    		} else {
    			throw new \Exception('Extension id does not exist');
    		}
    }    
}