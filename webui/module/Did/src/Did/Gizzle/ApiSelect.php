<?php
namespace Did\Gizzle;

use Zend\Paginator\Adapter\DbSelect;
use Zend\Db\ResultSet\ResultSetInterface;

class ApiSelect extends DbSelect
{
	protected $adapter;
	protected $resultSetPrototype;
	protected $count;
	public function __construct(ApiGatewayInterface $adapter, ResultSetInterface $resultSetPrototype = null)
	{
		$this->adapter = $adapter;		
		$this->resultSetPrototype = $resultSetPrototype;
	}
    public function count()
    {
        if (!$this->count)
        {
        	$this->adapter->getList(array('offset'=>1,'limit'=>0));
        	$this->count = $this->adapter->getCount();
        }
        return $this->count;
    }
    public function getItems($offset, $itemCountPerPage)
    {
    	return $this->adapter->getList(array('offset'=>$offset,'limit'=>$itemCountPerPage));    	 
    }
}