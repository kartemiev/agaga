<?php
namespace PbxAgi\Entity;
// use PbxAgi\Provider\Call\PeeridProvider;
// use PbxAgi\Provider\Call\VpbxidProvider;
use Zend\Stdlib\ArrayObject;

abstract class AbstractCallBearer extends ArrayObject
{
    // use PeeridProvider;
    // use VpbxidProvider;
    public  $id;

    public  $name;

    public  $extension;
    public $extensiongroup;

    public  $extensiontype;
    
    public $operatorstatus;
    
    public $outgoingcallspermission;    
    public $transfer;
    public $statuschange;
    public $incoming;
    public $hold;
    public $forwarding;
    public $memberofcallcentreque;
    public $mailbox;
    public $peertype;
 	public $routeref;
 	public $number_status;
 	
 	public $diversion_unconditional_status;
 	public $diversion_unconditional_number;
 	public $diversion_unavail_status;
 	public $diversion_unavail_number;
 	public $diversion_busy_status;
 	public $diversion_busy_number;
 	public $diversion_noanswer_status;
 	public $diversion_noanswer_number;
 	public $diversion_unavail_duration; 	
 
 	
    public  function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->extension = (isset($data['extension'])) ? $data['extension'] : null;
        $this->extensiongroup = (isset($data['extensiongroup'])) ? $data['extensiongroup'] : null;
        
        $this->extensiontype = (isset($data['extensiontype'])) ? $data['extensiontype'] : null;
                
        $this->outgoingcallspermission = (isset($data['outgoingcallspermission'])) ? $data['outgoingcallspermission'] : null;
        $this->transfer = (isset($data['transfer'])) ? $data['transfer'] : null;
        $this->statuschange = (isset($data['statuschange'])) ? $data['statuschange'] : null;
        $this->incoming = (isset($data['incoming'])) ? $data['incoming'] : null;
        $this->hold = (isset($data['hold'])) ? $data['hold'] : null;
        $this->forwarding = (isset($data['forwarding'])) ? $data['forwarding'] : null; 
        $this->memberofcallcentreque = (isset($data['memberofcallcentreque'])) ? $data['memberofcallcentreque'] : null;        
        $this->operatorstatus = (isset($data['operatorstatus'])) ? $data['operatorstatus'] : null;
        $this->mailbox = (isset($data['mailbox'])) ? $data['mailbox'] : null;
        $this->peertype = (isset($data['peertype'])) ? $data['peertype'] : null;
        $this->routeref = (isset($data['routeref'])) ? $data['routeref'] : null;
        $this->number_status = (isset($data['number_status'])) ? $data['number_status'] : null;
        
        $this->diversion_unconditional_number = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
        $this->diversion_unavail_status = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
        $this->diversion_unavail_number = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
        $this->diversion_busy_status = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
        $this->diversion_busy_number = (isset($data['diversion_busy_number'])) ? $data['diversion_busy_number'] : null;
        $this->diversion_noanswer_status = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        
        $this->diversion_noanswer_status = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        $this->diversion_noanswer_number = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;
        $this->diversion_unconditional_status = (isset($data['diversion_unconditional_status'])) ? $data['diversion_unconditional_status'] : null;
        $this->diversion_unconditional_number = (isset($data['diversion_unconditional_number'])) ? $data['diversion_unconditional_number'] : null;
        $this->diversion_unavail_status = (isset($data['diversion_unavail_status'])) ? $data['diversion_unavail_status'] : null;
        $this->diversion_unavail_number = (isset($data['diversion_unavail_number'])) ? $data['diversion_unavail_number'] : null;
        $this->diversion_busy_status = (isset($data['diversion_busy_status'])) ? $data['diversion_busy_status'] : null;
        $this->diversion_busy_number = (isset($data['diversion_busy_number'])) ? $data['diversion_busy_number'] : null;
        $this->diversion_noanswer_status = (isset($data['diversion_noanswer_status'])) ? $data['diversion_noanswer_status'] : null;
        $this->diversion_noanswer_number = (isset($data['diversion_noanswer_number'])) ? $data['diversion_noanswer_number'] : null;                       
        $this->diversion_unavail_duration = (isset($data['diversion_unavail_duration'])) ? $data['diversion_unavail_duration'] : null;        
         
    }
    

    public function getArrayCopy()
    {
    	return get_object_vars($this);
    }
    
	/**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

	/**
     * @return the $name
     */
    public function getName()
    {
        return $this->name;
    }

	/**
     * @return the $extension
     */
    public function getExtension()
    {
        return $this->extension;
    }

	/**
     * @return the $extensiontype
     */
    public function getExtensiontype()
    {
        return $this->extensiontype;
    }

	/**
     * @return the $forwardnum
     */

	/**
     * @return the $outgoingcallspermission
     */
    public function getOutgoingcallspermission()
    {
        return $this->outgoingcallspermission;
    }

	/**
     * @return the $transfer
     */
    public function getTransfer()
    {
        return $this->transfer;
    }

	/**
     * @return the $statuschange
     */
    public function getStatuschange()
    {
        return $this->statuschange;
    }

	/**
     * @return the $incoming
     */
    public function getIncoming()
    {
        return $this->incoming;
    }

	/**
     * @return the $hold
     */
    public function getHold()
    {
        return $this->hold;
    }

	/**
     * @return the $forwarding
     */
    public function getForwarding()
    {
        return $this->forwarding;
    }

	/**
     * @return the $memberofcallcentreque
     */
    public function getMemberofcallcentreque()
    {
        return $this->memberofcallcentreque;
    }

	/**
     * @param Ambigous <NULL, unknown> $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

	/**
     * @param Ambigous <NULL, unknown> $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

	/**
     * @param Ambigous <NULL, unknown> $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

	/**
     * @param Ambigous <NULL, unknown> $extensiontype
     */
    public function setExtensiontype($extensiontype)
    {
        $this->extensiontype = $extensiontype;
    }


	/**
     * @param Ambigous <NULL, unknown> $outgoingcallspermission
     */
    public function setOutgoingcallspermission($outgoingcallspermission)
    {
        $this->outgoingcallspermission = $outgoingcallspermission;
    }

	/**
     * @param Ambigous <NULL, unknown> $transfer
     */
    public function setTransfer($transfer)
    {
        $this->transfer = $transfer;
    }

	/**
     * @param Ambigous <NULL, unknown> $statuschange
     */
    public function setStatuschange($statuschange)
    {
        $this->statuschange = $statuschange;
    }

	/**
     * @param Ambigous <NULL, unknown> $incoming
     */
    public function setIncoming($incoming)
    {
        $this->incoming = $incoming;
    }

	/**
     * @param Ambigous <NULL, unknown> $hold
     */
    public function setHold($hold)
    {
        $this->hold = $hold;
    }

	/**
     * @param Ambigous <NULL, unknown> $forwarding
     */
    public function setForwarding($forwarding)
    {
        $this->forwarding = $forwarding;
    }

	/**
     * @param Ambigous <NULL, unknown> $memberofcallcentreque
     */
    public function setMemberofcallcentreque($memberofcallcentreque)
    {
        $this->memberofcallcentreque = $memberofcallcentreque;
    }
	/**
     * @return the $extensiongroup
     */
    public function getExtensiongroup()
    {
        return $this->extensiongroup;
    }

	/**
     * @param field_type $extensiongroup
     */
    public function setExtensiongroup($extensiongroup)
    {
        $this->extensiongroup = $extensiongroup;
    }
	/**
     * @return the $operatorstatus
     */
    public function getOperatorstatus()
    {
        return $this->operatorstatus;
    }

	/**
     * @param Ambigous <NULL, unknown> $operatorstatus
     */
    public function setOperatorstatus($operatorstatus)
    {
        $this->operatorstatus = $operatorstatus;
    }
	public function getMailbox()
    {
        return $this->mailbox;
    }

	public function setMailbox($mailbox)
    {
        $this->mailbox = $mailbox;
    }

    public function getPeerType()
    {
    	return $this->peertype;
    }
    public function setPeerType($peertype)
    {
    	$this->peertype = $peertype;
    	return $this;
    } 
    public function getRouteref()
    {
         return $this->routeref;
    }
    public function setRouteref($routeref)
    {
        $this->routeref = $routeref;
        return $this;
    }
    public function getNumberStatus()
    {
    	return $this->number_status;
    }
    public function setNumberStatus($numberstatus)
    {
    	$this->number_status = $numberstatus;
    	return $this;
    }
    public function getDiversionUnconditionalStatus()
    {
    	return $this->diversion_unconditional_status;
    }
    public function getDiversionUnconditionalNumber() { return $this->diversion_unconditional_number; }
    public function getDiversionUnavailStatus() { return $this->diversion_unavail_status; }
    public function getDiversionUnavailNumber() { return $this->diversion_unavail_number; }
    public function getDiversionBusyStatus() { return $this->diversion_busy_status; }
    public function getDiversionBusyNumber() { return $this->diversion_busy_number; }
    public function getDiversionNoanswerStatus() { return $this->diversion_noanswer_status; }
    public function getDiversionNoanswerNumber() { return $this->diversion_noanswer_number; }
    public function setDiversionUnconditionalStatus($x) { $this->diversion_unconditional_status = $x; }
    public function setDiversionUnconditionalNumber($x) { $this->diversion_unconditional_number = $x; }
    public function setDiversionUnavailStatus($x) { $this->diversion_unavail_status = $x; }
    public function setDiversionUnavailNumber($x) { $this->diversion_unavail_number = $x; }
    public function setDiversionBusyStatus($x) { $this->diversion_busy_status = $x; }
    public function setDiversionBusyNumber($x) { $this->diversion_busy_number = $x; }
    public function setDiversionNoanswerStatus($x) { $this->diversion_noanswer_status = $x; }
    public function setDiversionNoanswerNumber($x) { $this->diversion_noanswer_number = $x; }

    public function getDiversionUnavailDuration() { return $this->diversion_unavail_duration;}    
    public function setDiversionUnavailDuration($x) { $this->diversion_unavail_duration = $x; return $this; }
}

