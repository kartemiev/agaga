<?php
namespace PbxAgi\Service\ConferenceMenu;

use PbxAgi\Service\ConferenceMenu\ConferenceCredentialsContainerInterface;

class ConferenceCredentialsContainer implements ConferenceCredentialsContainerInterface
{
    protected $confpin;
    protected $confnumber;
    protected $joinacl;
	public function getConfpin()
    {
        return $this->confpin;
    }

	public function getConfnumber()
    {
        return $this->confnumber;
    }

	public function setConfpin($confpin)
    {
        $this->confpin = $confpin;
    }

	public function setConfnumber($confnumber)
    {
        $this->confnumber = $confnumber;
    }

 	public function getJoinacl() {
  		return $this->joinacl;
 	}
 
 	public function setJoinacl($joinacl) {
  		$this->joinacl = $joinacl;
 	    return $this;
 	}
             
}