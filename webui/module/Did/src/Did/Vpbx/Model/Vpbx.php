<?php
namespace Did\Vpbx\Model;

class Vpbx
{
    public $id;    
    public $vpbx;
    public $description;
	public $remotevpbxid;
	public $created;
	public $expiry;
	 
	public function exchangeArray($data)
	{
		$this->id = (isset($data['id']))? $data['id']:null;
		$this->vpbx = (isset($data['vpbx']))? $data['vpbx']:null;
		$this->description = (isset($data['description']))? $data['description']:null;
		$this->remotevpbxid = (isset($data['remotevpbxid']))? $data['remotevpbxid']:null;
		$this->created = (isset($data['created']))? $data['created']:null;
		$this->expiry = (isset($data['expiry']))? $data['expiry']:null;		
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
}