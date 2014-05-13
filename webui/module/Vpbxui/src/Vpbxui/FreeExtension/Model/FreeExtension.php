<?php
namespace Vpbxui\FreeExtension\Model;
 
use Zend\Db\Adapter\AdapterInterface;

class FreeExtension
{
    public $ext;
   
    
    protected  $dbAdapter;    
    
    public function __construct(AdapterInterface $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }
    
    public function exchangeArray($data)
    {
     
        $this->ext     = (isset($data['ext'])) ? $data['ext'] : null;          
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

 }
