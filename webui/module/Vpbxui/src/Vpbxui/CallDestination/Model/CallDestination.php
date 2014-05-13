<?php
namespace Vpbxui\CallDestination\Model;

class CallDestination
{
	public $peerid;
	public $number;	
	public $duration;
	public function setNumber($number)
	{
	    $this->number = $number;
	    return $this;
	}
	
	public function getNumber()
	{
	    return $this->number;
	}
	
	public function setPeerid($peerid)
	{
		$this->peerid = $peerid;
		return $this;
	}
	
	public function getPeerid()
	{
		return $this->peerid;
	}
	
	public function setDuration($duration)
	{
		$this->duration = $duration;
		return $this;
	}
	
	public function getDuration()
	{
		return $this->duration;
	}
	public function exchangeArray($data)
	{
		$this->peerid     = (isset($data['peerid'])) ? $data['peerid'] : null;
		$this->number     = (isset($data['number'])) ? $data['number'] : null;
		$this->duration     = (isset($data['duration'])) ? $data['duration'] : null;		
	}
}