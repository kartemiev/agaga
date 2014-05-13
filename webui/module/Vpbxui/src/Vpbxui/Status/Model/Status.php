<?php
namespace Vpbxui\Status\Model;
 
class Status 
{
    public $id;
    public $extension;
    public $name;
    public $secret;
    public $custname;
    public $custdesc;
    public $extensiontype;
    public $callerid;
    public $operatorstatus;
    protected $inputFilter;                       // <-- Add this variable
    
    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->extension     = (isset($data['extension'])) ? $data['extension'] : null;        
        $this->name     = (isset($data['name'])) ? $data['name'] : null;        
        $this->callerid     = (isset($data['callerid'])) ? $data['callerid'] : null;        
 
        $this->secret     = (isset($data['secret'])) ? $data['secret'] : null;
        $this->extensiontype = (isset($data['extensiontype'])) ? $data['extensiontype'] : null;
        $this->custname     = (isset($data['custname'])) ? $data['custname'] : null;
        $this->custdesc     = (isset($data['custdesc'])) ? $data['custdesc'] : null;
        $this->operatorstatus     = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        
     }
     
     public function getArrayCopy()
     {
     	return get_object_vars($this);
     }

     
}
