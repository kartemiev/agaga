<?php
namespace Saas\FreeDid\Model;

class FreeDid
{
	public $id;
	public $didissuancepool;
	public $areacode;
	public $digits;
	public $didtype;
	public $status;
	public $provider;
	public $providerincomingtrunk;
	public $dateissuedtovpbx;
	public $dateexpiryforvpbx;
	public $dateissuedbyprovider;
	public $dateexpiryforprovider;
	public $vpbx;
	public $vpbxtrunk;
	public $reservationdate;
	public $reserveduntil;
	public function exchangeArray($data)
	{
		$this->id = (isset($data['id']))? $data['id']:null;
		$this->didissuancepool = (isset($data['didissuancepool']))? $data['didissuancepool']:null;
		$this->areacode = (isset($data['areacode']))? $data['areacode']:null;
		$this->digits = (isset($data['digits']))? $data['digits']:null;
		$this->didtype = (isset($data['didtype']))? $data['didtype']:null;
		$this->status = (isset($data['status']))? $data['status']:null;
		$this->provider = (isset($data['provider']))? $data['provider']:null;
		$this->providerincomingtrunk = (isset($data['providerincomingtrunk']))? $data['providerincomingtrunk']:null;
		$this->dateissuedtovpbx = (isset($data['dateissuedtovpbx']))? $data['dateissuedtovpbx']:null;
		$this->dateexpiryforvpbx = (isset($data['dateexpiryforvpbx']))? $data['dateexpiryforvpbx']:null;
		$this->dateissuedbyprovider = (isset($data['dateissuedbyprovider']))? $data['dateissuedbyprovider']:null;
		$this->dateexpiryforprovider = (isset($data['dateexpiryforprovider']))? $data['dateexpiryforprovider']:null;
		$this->vpbx = (isset($data['vpbx']))? $data['vpbx']:null;
		$this->vpbxtrunk = (isset($data['vpbxtrunk']))? $data['vpbxtrunk']:null;		
		$this->reservationdate = (isset($data['reservationdate']))? $data['reservationdate']:null;
		$this->reserveduntil = (isset($data['reserveduntil']))? $data['reserveduntil']:null;	
	}
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
}